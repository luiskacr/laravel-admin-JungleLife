<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Mail\InvoiceMail;
use App\Models\ClientType;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\MoneyType;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\Tour;
use App\Models\ExchangeRate;
use App\Models\TourClient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Display a Custom view of booking process
     *
     * @return View
     */
    public function index():View
    {
        $dateValue = Carbon::now('America/Costa_Rica')->format('Y-m-d');
        $exchange_rate = ExchangeRate::where('date', '=', $dateValue)->take(1)->get();

        if($exchange_rate->isEmpty()){
            return view('admin.booking.error');
        }

        $rate = [
            'id' => $exchange_rate[0]->id,
            'date' => $dateValue,
            'buy' => $exchange_rate[0]->buy,
            'sell' => $exchange_rate[0]->sell,
        ];

        return view('admin.booking.index')
            ->with('products', Product::all())
            ->with('clientTypes', ClientType::all())
            ->with('paymentTypes',PaymentType::all())
            ->with('moneyTypes', MoneyType::all())
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
        DB::beginTransaction();
        try{
            $total = 0;
            $tourBookings = 0;
            $royalties = 0;
            $newInvoice = Invoice::create([
                'client' => $invoice['costumer']['id'],
                'date' => $invoice['invoice']['date'],
                'total' => $total,
                'state' => $invoice['invoice']['credit']
                    ? 1
                    : 2,
                'type' => $invoice['invoice']['credit']
                    ? 4
                    : $invoice['invoice']['paymentType'] ,
                'money' => $invoice['invoice']['currency'],
                'exchange' => $invoice['invoice']['exchange']['id'],
                'info' => $invoice['invoice']['info'],
            ]);

            foreach ($invoice['product'] as $product){
                $productTotal = $product['quantity'] * $product['price'];
                $productOrg = Product::findOrFail($product['id']);

                $detail = InvoiceDetails::create([
                    'invoice' => $newInvoice->id ,
                    'product' => $product['id'],
                    'tour' => $productOrg->type == 1 ? $invoice['tour']['id'] : null,
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'total' => $productTotal,
                    'money' => $invoice['invoice']['currency'] ,
                    'exchange' => $invoice['invoice']['exchange']['id'],
                ]);

                $total = $total + $productTotal;
                $tourBookings = ($productOrg->type == 1 and ($productOrg->price != 0 or $productOrg->price !== null))
                    ? $tourBookings + $product['quantity']
                    : $tourBookings;
                $royalties = ($productOrg->price == 0 or $productOrg->price == null)
                    ? $royalties + $product['quantity']
                    : $royalties;
            }

            TourClient::create([
                'tour' => $invoice['tour']['id'] ,
                'client' => $invoice['costumer']['id'] ,
                'bookings'=> $tourBookings,
                'royalties' => $royalties,
                'present' => false,
                'invoice' => $newInvoice->id
            ]);

            $newInvoice->total = $total;
            $newInvoice->state = $invoice['invoice']['credit']
                ? 1
                : 2;
            $newInvoice->save();

            $tour = Tour::findOrFail($invoice['tour']['id']);

            if($invoice['invoice']['invoice']){
                Mail::to($invoice['costumer']['email'] )->queue(new InvoiceMail($newInvoice, $invoice['product'] , $invoice['costumer'], $tour));
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


    /**
     * Display the Thanks View in the final booking process
     *
     * @param $id
     * @return View
     */
    public function thanks($id):View
    {
        return view('admin.booking.thanks')
            ->with('invoice', Invoice::findOrFail($id))
            ->with('details', InvoiceDetails::all()->where('invoice','=', $id));
    }

}
