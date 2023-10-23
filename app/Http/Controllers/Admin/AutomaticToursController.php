<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timetables;
use App\Models\TourType;
use App\Traits\ResponseTrait;
use App\Traits\TourTraits;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AutomaticToursController extends Controller
{
    use tourTraits, ResponseTrait;

    /**
     * Return a View
     *
     * @return View
     */
    public function index():View
    {
        return view('admin.automatic.index')
            ->with('tourTypes', TourType::all());
    }


    public function getTimeTables(Request $request)
    {
        return response()->json(Timetables::where('type', '=', $request->request->get('id'))->get());
    }

    public function automaticTourCreation(Request $request)
    {
        $start = Carbon::parse($request->request->get('start'));
        $end = Carbon::parse($request->request->get('end'))->addDay();
        $timeTables = Timetables::where('type','=',$request->request->getInt('tourType'))
            ->where('auto', '=', 1)->get();

        try{
            DB::beginTransaction();
            while($start->lt($end)){
                foreach ($timeTables as $timeTable){
                    $this->creatTour($timeTable, $start, 1 , __('app.auto_system') );
                }
                $start->addDay();
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
            return $this->errorJsonResponse($e->getMessage(), 'Error al crear los toures automaticamente','error');
        }
        return $this->successJsonResponse(['message'=> 'Tours creados satisfactoriamente']);
    }
}
