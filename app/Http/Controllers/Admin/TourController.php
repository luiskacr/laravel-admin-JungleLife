<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientType;
use App\Models\Customer;
use App\Models\Guides;
use App\Models\GuidesType;
use App\Models\Timetables;
use App\Models\Tour;
use App\Models\TourClient;
use App\Models\TourGuides;
use App\Models\TourState;
use App\Models\TourType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Time;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $tours =Tour::where('state' ,'=','1')
            ->orderBy('end', 'asc')
            ->get();

        return view('admin.tour.index')
            ->with('tours',$tours);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $timetables = Timetables::all();

        $tourTypes = TourType::all();

        return view('admin.tour.create')
            ->with('timetables',$timetables)
            ->with('tourTypes',$tourTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
        public function store(Request $request)
    {
        $this->validateCreateRequest($request);

        DB::beginTransaction();
        try{

            $timetable = Timetables::findOrFail($request->request->getInt('time'));

            Tour::create([
                'title' =>  __('app.tour_singular') . ' del ' .  Carbon::parse($request->request->get('date'))->format('d/m/Y') . ' ' . __('app.from'). Carbon::parse($timetable->start)->format('g:i A'). __('app.to') . Carbon::parse($timetable->end)->format('g:i A') ,
                'start' => Carbon::parse($request->request->get('date'). ' '. Carbon::parse($timetable->start)->format('g:i A'))->format('Y-m-d H:i:s') ,
                'end' => Carbon::parse($request->request->get('date'). ' '. Carbon::parse($timetable->end)->format('g:i A'))->format('Y-m-d H:i:s'),
                'info' => $request->request->get('info'),
                'state' => 1,
                'type' => 1,
                'user' => Auth::user()->id,
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message =$e->getMessage() : $message = __('app.error_create', ['object' => __('app.tour_singular')]) ;

            return redirect()->route('tours.create')->with('message',$message);
        }
        return redirect()->route('tours.index')
            ->with('success',__('app.success_create ',['object' => __('app.tour_singular') ] ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View |\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $tour = Tour::findOrFail($id);

        if($tour->state != 1 ){
            return redirect()->route('tour-history.index')
                ->with('error',__('app.error_not_found',['object' => __('app.tour_singular') ] ));
        }

        $tour_has_guides = TourGuides::all()->where('tour','=',$id);
        $guides = Guides::all();
        $typeGuides = GuidesType::all();
        $clientTypes = ClientType::all();
        $tour_has_clients = TourClient::all()->where('tour','=',$id);

        return view('admin.tour.show')
            ->with('tour',$tour)
            ->with('tourGuides',$tour_has_guides)
            ->with('guides',$guides)
            ->with('typeGuides',$typeGuides)
            ->with('clients',$tour_has_clients)
            ->with('clientTypes',$clientTypes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $tour = Tour::findOrFail($id);

        if($tour->state != 1 ){
            return redirect()->route('tour-history.index')
                ->with('error',__('app.error_not_found',['object' => __('app.tour_singular') ] ));
        }

        $tourStates = TourState::all();

        $tourTypes = TourType::all();

        $timetables = Timetables::all();

        return view('admin.tour.edit')
            ->with('tour',$tour)
            ->with('tourStates',$tourStates)
            ->with('tourTypes',$tourTypes)
            ->with('timetables',$timetables);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validateUpdateRequest($request);

        DB::beginTransaction();
        try{

            $timetable = Timetables::findOrFail($request->request->getInt('time'));

            Tour::whereId($id)->update([
                'title' => $request->request->get('name'),
                'start' => Carbon::parse($request->request->get('date'). ' '. Carbon::parse($timetable->start)->format('g:i A'))->format('Y-m-d H:i:s') ,
                'end' => Carbon::parse($request->request->get('date'). ' '. Carbon::parse($timetable->end)->format('g:i A'))->format('Y-m-d H:i:s'),
                'info' => $request->request->get('info'),
                'state' => $request->request->getInt('tour-state'),
                'type' => $timetable->type,
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message =$e->getMessage() : $message = __('app.error_update', ['object' => __('app.tour_singular')]) ;

            return redirect()->route('tours.update',$id)->with('message',$message);
        }

        return redirect()->route('tours.index')
            ->with('success',__('app.success_update',['object' => __('app.tour_singular') ] ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $tour = Tour::findOrFail($id);

            if($tour->state != 1 ){
                return response("Error",404);
            }

            $tour->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete') ;

            return response($message,500);
        }
        return response(__('app.success'),200);
    }

    /**
     *  Validate the Create Request Form
     *
     * @param Request $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateCreateRequest(Request $request)
    {
        $rules = [
            'date' => 'required|date',
            'time' => 'required|not_in:0',
        ];

        $attrubutes =[
            'date' => __('app.date'),
            'time' => __('app.timetables'),
        ];

        $this->validate($request, $rules, [], $attrubutes);
    }

    public function validateUpdateRequest(Request $request)
    {
        $rules = [
            'name' => 'required|min:2|max:100',
            'date' => 'required|date',
            'time' => 'required|not_in:0',
            'tour-state' => 'required|not_in:0',
            'info' => 'max:500',
        ];

        $attrubutes =[
            'name' => __('app.name'),
            'date' => __('app.date'),
            'time' => __('app.timetables'),
            'tour-state' => __('app.tour_states_singular'),
            'info' => __('app.info_tours'),
        ];

        $this->validate($request, $rules, [], $attrubutes);
    }
}
