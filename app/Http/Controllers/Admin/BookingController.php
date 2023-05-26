<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Mail\InvoiceMail;
use App\Models\ClientType;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\Tour;
use App\Models\ExchangeRate;
use App\Models\TourClient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index()
    {
        $dateValue = Carbon::now('America/Costa_Rica')->format('Y-m-d');

        $products = Product::all();
        $clientTypes = ClientType::all();
        $paymentTypes = PaymentType::all();
        $exchange_rates = ExchangeRate::where('date', '=', $dateValue)->take(1)->get();

        $rate = [
            'id' => $exchange_rates[0]->id,
            'date' => $dateValue,
            'buy' => $exchange_rates[0]->buy,
            'sell' => $exchange_rates[0]->sell,
        ];

        return view('admin.booking.index')
            ->with('products',$products)
            ->with('clientTypes',$clientTypes)
            ->with('paymentTypes',$paymentTypes)
            ->with('exchange_rates',$rate);
    }


    public function getTour(Request $request)
    {
        $date = Carbon::parse($request->date)->format('Y-m-d');

        $tours = Tour::whereDate('start', '=', $date)->where('state','=','1')->get();

        return response()->json($tours);

    }

    public function availableSpace(Request $request)
    {
        $tour = Tour::findOrFail($request->get('tour'));
        return response()->json($tour->availableSpace());
    }

    public function createClient(Request $request){
        DB::beginTransaction();
        try{
            $client = Customer::create([
                'name' => $request->request->get('name'),
                'email' => $request->request->get('email'),
                'telephone' => $request->request->get('telephone') ,
                'clientType' => $request->request->getInt('clientType') ,
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            return response('Error', 500);
        }
        return response()->json($client);
    }

    public function getClient(Request $request )
    {
        $client = Customer::findOrFail($request->get('client'));

        return response()->json($client);
    }

    public function booking(Request $request)
    {
        $invoice = $request->all();
        $invoiceDetail = [];

        DB::beginTransaction();
        try{

            $total = 0;
            $newInvoice = Invoice::create([
                'client' => $invoice['costumer']['id'],
                'date' => $invoice['invoice']['date'],
                'total' => $total,
                'state' => 1,
                'type' => 1,
                'money' => $invoice['invoice']['currency'],
                'exchange' => $invoice['invoice']['exchange']['id'],
            ]);

            foreach ($invoice['product'] as $product){
                $productTotal = $product['quantity'] * $product['price'];
                $detail = InvoiceDetails::create([
                    'invoice' => $newInvoice->id ,
                    'product' => $product['id'],
                    'tour' => $invoice['tour']['id'],
                    'quantity' => $product['quantity'],
                    'total' => $productTotal,
                    'money' => $invoice['invoice']['currency'] ,
                    'exchange' => $invoice['invoice']['exchange']['id'],
                ]);
                $invoiceDetail[] = $detail;
                $total = $total + $productTotal;
            }

            TourClient::create([
                'tour' => $invoice['tour']['id'] ,
                'client' => $invoice['costumer']['id'] ,
                'bookings'=> count($invoice['product'],0),
                'present' => false,
                'invoice' => $newInvoice->id
            ]);

            $newInvoice->total = (int)$total;
            $newInvoice->state = 2;
            $newInvoice->save();


            if($invoice['invoice']['invoice']){
                Mail::to($invoice['costumer']['email'] )->send(new InvoiceMail($newInvoice, $invoice['product'] , $invoice['costumer'] ));
            }

            if($invoice['invoice']['electronic_invoice']){
                //Factura Electronica
            }

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            return response($e->getMessage(), 500);
        }
        return response()->json([
            'invoice' => $newInvoice->id,
            'message' => __('app.thanks')
        ]);
    }

    public function thanks($id){

        $invoice = Invoice::findOrFail($id);
        $details = InvoiceDetails::all()->where('invoice','=', $id);

        return view('admin.booking.thanks')
            ->with('invoice', $invoice)
            ->with('details', $details);
    }

}
