<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientType;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $clientTypes = ClientType::all();

        return view('admin.booking.index')->with('products',$products)->with('clientTypes',$clientTypes);
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
}
