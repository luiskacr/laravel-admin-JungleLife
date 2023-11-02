<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\InvoiceDataTable;
use App\Http\Controllers\Controller;
use App\Mail\InvoiceMail;
use App\Models\Configuration;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\InvoiceState;
use App\Models\PaymentType;
use App\Models\Tour;
use App\Traits\ResponseTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\Request;


class InvoiceController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @param InvoiceDataTable $dataTable
     * @return mixed
     */
    public function index(InvoiceDataTable $dataTable):mixed
    {
        return $dataTable->render('admin.invoice.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     * @throws AuthorizationException
     */
    public function show(int $id):View
    {
        $this->validateShow($id);

        $config = Configuration::findOrFail(4);

        return view('admin.invoice.show')
            ->with('invoice', Invoice::findOrFail($id))
            ->with('invoiceDetails',InvoiceDetails::where('invoice','=',$id)->get())
            ->with('prefix',$config->data['value']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id):View
    {
        $config = Configuration::findOrFail(4);

        return view('admin.invoice.edit')
            ->with('invoice', Invoice::findOrFail($id))
            ->with('invoiceDetails',InvoiceDetails::where('invoice','=',$id)->get())
            ->with('paymentTypes', PaymentType::all() )
            ->with('invoiceStates', InvoiceState::all() )
            ->with('prefix',$config->data['value']);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request,int $id):RedirectResponse
    {
        DB::beginTransaction();
        try{
            Invoice::whereId($id)->update([
                'state' => $request->get('state'),
                'type'  => $request->get('paymentType'),
                'info' => $request->get('info'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorResponse('invoice.edit' , $e->getMessage(), __('app.error_update', ['object' => __('app.invoice') ]) );
        }
        return $this->successUpdateResponse('invoice.index', __('app.invoice') );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id):Response
    {
        DB::beginTransaction();
        try{
            $invoice = Invoice::findOrFail($id);
            $invoice->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            return $this->errorDestroyResponse( $e, __('app.error_delete'), 500 );
        }
        return $this->successDestroyResponse(__('app.success'));
    }

    /**
     * Display the specified Invoice.
     *
     * @param int $id
     * @return Response
     * @throws \ReflectionException
     */
    public function showInvoice(int $id):Response
    {
        $invoice = Invoice::findOrFail($id);

        $details = InvoiceDetails::where('invoice', '=',$invoice->id)->get();
        $product = array();

        foreach ($details as $detail){
            $product[] = [
                'name' => $detail->getProduct->name,
                'quantity' => $detail->quantity,
                'price' => $detail->getProduct->price,
            ];
        }

        $invoiceMailable = new InvoiceMail(
            $invoice,
            $product,
            Customer::withTrashed()->findOrFail($invoice->client)->toArray(),
            Tour::withTrashed()->findOrFail($invoice->getTourId())
        );
        $renderedEmail = $invoiceMailable->render();

        return response($renderedEmail)->header('Content-Type', 'text/html');
    }

    /**
     * Send a specified Invoice.
     *
     * @param int $id
     * @return JsonResponse|Response
     */
    public function sendInvoice(int $id):JsonResponse|Response
    {
        try{
            $invoice = Invoice::findOrFail($id);

            $details = InvoiceDetails::where('invoice', '=',$invoice->id)->get();
            $product = array();

            foreach ($details as $detail){
                $product[] = [
                    'name' => $detail->getProduct->name,
                    'quantity' => $detail->quantity,
                    'price' => $detail->getProduct->price,
                ];
            }

            $client = Customer::withTrashed()->findOrFail($invoice->client)->toArray();

            Mail::to($client['email'] )
                ->queue(
                    new InvoiceMail( $invoice, $product , $client , Tour::withTrashed()->findOrFail($invoice->getTourId()) )
                );

        }catch (\Exception $e){

            return $this->errorDestroyResponse( $e , __('app.error_delete'), 500 );
        }
        return $this->successJsonResponse(['message' => __('app.invoice_message_send')]);
    }

    /**
     * Validate the rol and if the invoice is for a specific user
     *
     * @param int $id
     * @return void
     */
    public function validateShow(int $id): void
    {
        $user = Auth::user();
        if($user->hasRole('Tour Operador')){
            $exist = true;
            $customer = Customer::where('email', '=', $user->email)->first();
            $invoiceValidation = Invoice::where('client', '=',$customer->id)->get();
            foreach ($invoiceValidation as $validation){
                if($validation->id == $id){
                    $exist = false;
                }
            }
            if($exist){
                abort(404);
            }
        }
    }
}
