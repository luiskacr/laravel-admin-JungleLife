<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Mail\InvoiceMail;
use App\Models\Configuration;
use App\Models\Customer;
use App\Models\ExchangeRate;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\Product;
use App\Models\Tour;
use App\Models\TourClient;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    use ApiResponseTrait;

    /**
     *
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws \Exception
     */
    function booking(Request $request): JsonResponse
    {
        $validation = $this->validateRequest($request);

        if($this->validateRequest($request))
        {
            return $this->validationErrorMessage($validation , 442);
        }

        DB::beginTransaction();
        try {
            $total = 0;
            $tourBookings = 0;
            $royalties = 0;
            $products = [];

            $booking = $request->all();

            $dateValue = Carbon::now('America/Costa_Rica')->format('Y-m-d');
            $exchange_rate = ExchangeRate::where('date', '=', $dateValue)->first();
            $customer = Customer::where('email' , '=' , $booking['costumer']['email'])->first();
            $tour = Tour::findOrFail( $booking['tour_id'] );


            if($customer == null){
                $customer = Customer::create([
                    'name' => $booking['costumer']['name'],
                    'email' => $booking['costumer']['email'],
                    'telephone' => $booking['costumer']['telephone'] ,
                    'clientType' => 4 ,
                ]);
            }else{
                $customer->name = $booking['costumer']['name'];
                $customer->telephone =  $booking['costumer']['telephone'];
                $customer->save();
            }

            $newInvoice = Invoice::create([
                'client' => $customer->id,
                'date' => $dateValue,
                'total' => $total,
                'state' => 2,
                'type' => 5,
                'money' => 2,
                'exchange' => $exchange_rate == null
                    ? 1
                    : $exchange_rate->id,
                'info' => $booking['invoice']['info'],
            ]);

            foreach ($booking['products'] as $product){

                $productTotal = $product['quantity'] * $product['price'];
                $productOrg = Product::findOrFail($product['id']);

                $detail = InvoiceDetails::create([
                    'invoice' => $newInvoice->id ,
                    'product' => $productOrg->id,
                    'tour' => $productOrg->type == 1 ? $tour->id : null,
                    'price' => $productOrg->price == null
                        ? 0
                        : $productOrg->price ,
                    'quantity' => $product['quantity'],
                    'total' => $productTotal,
                    'money' => 2 ,
                    'exchange' => $exchange_rate == null
                        ? 1
                        : $exchange_rate->id,
                ]);

                $total = $total + $productTotal;
                $tourBookings = ($productOrg->type == 1 and ($productOrg->price != 0 or $productOrg->price !== null))
                    ? $tourBookings + $product['quantity']
                    : $tourBookings;
                $royalties = ($productOrg->price == 0 or $productOrg->price == null)
                    ? $royalties + $product['quantity']
                    : $royalties;

                $products[] = [
                    'name' => $productOrg->name,
                    'quantity' => $product['quantity'],
                    'price' => $productOrg->price == null
                        ? 0
                        : $detail->getProduct->price  ,
                ];
            }

            TourClient::create([
                'tour' => $booking['tour_id'] ,
                'client' => $customer->id,
                'bookings'=> $tourBookings,
                'royalties' => $royalties,
                'present' => false,
                'invoice' => $newInvoice->id
            ]);

            $newInvoice->total = $total;
            $newInvoice->save();

            if($booking['invoice']['send_invoice'])
            {
                Mail::to($customer->email )->queue(new InvoiceMail($newInvoice, $products , $customer->toArray() , $tour));
            }

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            return $this->errorResponse($e,'Internal ERROR' );
        }

        return $this->successResponse(['Invoice'=> $this->invoiceResponse($newInvoice) ]);
    }

    /**
     * Validate Request Fields
     *
     * @param Request $request
     * @return array|null
     */
    public function validateRequest(Request $request): ?array
    {
        $tourValidation = $this->tourValidation($request);

        if($tourValidation !=null){
            return $tourValidation;
        }

        $rules = [
            'invoice' => 'required',
            'invoice.send_invoice' => 'required|bool',
            'invoice.total' => 'required|integer',
            'invoice.info' => 'required',
            'costumer'=> 'required',
            'costumer.name'=> 'required|max:150',
            'costumer.email'=> 'required|email',
            'costumer.telephone'=> 'required|max:10',
            'tour_id'=>'required',
            'products'=>'required',
            'products.*.id'=>'required',
            'products.*.name'=>'required',
            'products.*.quantity'=>'required|integer',
            'products.*.price'=>'required',
        ];

        $attribute = [
            'invoice.send_invoice'=> 'send_invoice',
            'invoice.total'=> 'total',
            'invoice.info'=> 'info',
            'costumer.name'=> 'costumer name',
            'costumer.email'=> 'costumer email',
            'costumer.telephone'=> 'telephone',
            'products.*.id'=> 'product id',
            'products.*.name'=> 'product name',
            'products.*.quantity'=> 'product quantity',
            'products.*.price'=> 'product price',
        ];

        $validator = Validator::make($request->all(), $rules, [] , $attribute);

        return  $validator->fails()
            ? $validator->errors()->jsonSerialize()
            : null;
    }

    /**
     * A custom validation from Tour Business Logic.
     *
     * @param Request $request
     * @return array|null
     */
    public function tourValidation(Request $request): ?array
    {
        $response= [];
        $reservations = 0;
        $booking = $request->all();
        $tour =  Tour::findOrFail($booking['tour_id']);
        $tourAvailableSpace = $tour->availableSpace();

        if($tour->state != 1){
            $response['tour_id'] = [
                'The tour_id does not exist or is not open'
            ];
        }

        if($tourAvailableSpace < 0)
        {
            $response['tour_id'] = !empty($response['tour_id'])
                ? [$response['tour_id'][0],'The tour does not have space']
                :  ['The tour does not have space'];
        }

        foreach ($booking['products'] as $product){
            $reservations = $reservations +   $product['quantity'];
        }

        if($tourAvailableSpace < $reservations)
        {
            $response['tour_id'] = !empty($response['tour_id'])
                ? [$response['tour_id'][0],'Bookings exceed available space on the tour']
                :  ['Bookings exceed available space on the tour'];
        }

        return empty($response)
            ? null
            : $response;
    }

    /**
     * Convert Invoice Model to Array Values Response
     *
     * @param Invoice $invoice
     * @return array
     */
    public function invoiceResponse(Invoice $invoice):array
    {
        $config = Configuration::findOrFail(4);

        return[
            'id' => $invoice->id,
            'invoice' => $config->data['value'].$invoice->id,
            'date' => Carbon::parse($invoice->date)->format('d/m/Y'),
            'total' => (int)$invoice->total,
            'invoice_state' =>[
                'id' => $invoice->state,
                'name' => $invoice->getState->name
            ],
            'money' =>[
                'id' => $invoice->money,
                'name' => $invoice->getMoney->name
            ],
            'exchange_rate' => [
                'id' => $invoice->exchange,
                'date' => Carbon::parse($invoice->getExchange->date)->format('d/m/Y'),
                'buy' => (int)$invoice->getExchange->buy,
                'sell' => (int)$invoice->getExchange->sell,
            ],
            'info' => $invoice->info,
            'client'=>[
                'id' => $invoice->client,
                'name' => $invoice->getClient->name,
                'email'  => $invoice->getClient->email,
                'telephone'=> $invoice->getClient->telephone,
            ]
        ];
    }

}

