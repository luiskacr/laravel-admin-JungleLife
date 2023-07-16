<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Guides;
use App\Models\TourClient;
use App\Models\TourGuides;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TourOptionsController extends Controller
{

    public function setTourGuide(Request $request,int $id)
    {
        if($this->validateIfExist($request->get('tour'),$request->get('guides')))
        {
            return response(__('app.error_tour_exist_guide'),406);
        }

        DB::beginTransaction();
        try{

            TourGuides::create([
                'tour' => $request->get('tour'),
                'guides' => $request->get('guides')
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete') ;

            return response($message,500);
        }
        return response(__('app.success'), 200);
    }


    public function deleteTourGuide(int $id)
    {
        DB::beginTransaction();
        try{
            $tourGuides = TourGuides::findOrFail($id);
            $tourGuides->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete') ;

            return response($message,500);
        }
        return response(__('app.success'),200);
    }

    public function createGuide(Request $request,int $id){
        DB::beginTransaction();
        try{

            $guides = Guides::create([
                'name' => $request->request->get('name') ,
                'lastName' => $request->request->get('lastName'),
                'type' => $request->request->getInt('type'),
            ]);

            TourGuides::create([
                'tour' => $id,
                'guides' => $guides->id
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_create', ['object'=> __('app.guide')]) ;

            return response($message,500);
        }
        return response(__('app.success'),200);
    }

    public function searchCustomer(int $id, Request $request){
        $search = $request->search;

        if($search==''){
            $customers = Customer::orderby('id','desc')->select('id','name','email')
                ->limit(5)
                ->get();
        }else{
            $customers = Customer::orderby('name','asc')->select('id','name','email')
                ->where('name', 'like', '%' .$search . '%')
                ->orWhere('email', 'like', '%' .$search . '%')
                ->limit(5)
                ->get();
        }
        $response = array();
        foreach($customers as $customer){
            $response[] = array(
                "id"=>$customer->id,
                "text"=>'Nombre: '.$customer->name.' | Correo: ' .$customer->email
            );
        }
        return response()->json($response);
    }

    public function setClientTour(Request $request,int $id)
    {
        if($this->validateClientIfExist($request->get('tour'),$request->get('client')))
        {
            return response(__('app.error_tour_exist_guide'),406);
        }
        DB::beginTransaction();
        try{

            TourClient::create([
                'tour'=>$request->get('tour'),
                'client'=>$request->get('client'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete') ;

            return response($message,500);
        }
        return response(__('app.success'),200);
    }

    public function createClient(Request $request,int $id){
        dd($request->request);
    }

    public function validateCustomerEmail(Request $request)
    {
        $costumer = Customer::all()->where('email','=',$request->get('email'))->isEmpty();

        return response()->json([
            'validation' => !$costumer
        ]);
    }

    public function presentCostumer(Request $request)
    {
        DB::beginTransaction();
        try{

            $tourClients = TourClient::findOrFail($request->request->getInt('tourClients'));

            $tourClients->update([
                'present' => $request->request->getBoolean('value')
            ]);


            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete') ;

            return response($message,500);
        }

        return response()->json([
            'message' => __('app.success_is_present')
        ]);
    }

    public function setGuideToCustomer(Request $request)
    {
        DB::beginTransaction();
        try{

            $tourClients = TourClient::findOrFail($request->request->getInt('tourClients'));

            $tourClients->update([
                'guides' => $request->request->getInt('value') == 0
                    ? null
                    : $request->request->getInt('value')
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            app()->hasDebugModeEnabled()
                ? $message = $e->getMessage()
                : $message = __('app.error_delete') ;

            return response($message,500);
        }

        return response()->json([
            'message' => __('app.success_set_guide_to_costumer')
        ]);
    }


    private function validateIfExist($tour, $guide)
    {
        return TourGuides::where('tour',$tour)
            ->where('guides',$guide)
            ->exists();
    }

    private function validateClientIfExist($tour,$client)
    {
        return TourClient::where('tour',$tour)
            ->where('client',$client)
            ->exists();
    }

}
