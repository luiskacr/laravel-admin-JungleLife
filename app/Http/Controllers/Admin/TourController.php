<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ToursDataTable;
use App\Http\Controllers\Controller;
use App\Models\ClientType;
use App\Models\Guides;
use App\Models\GuidesType;
use App\Models\Timetables;
use App\Models\Tour;
use App\Models\TourClient;
use App\Models\TourGuides;
use App\Models\TourState;
use App\Models\TourType;
use App\Traits\ResponseTrait;
use App\Traits\TourTraits;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class TourController extends Controller
{
    use TourTraits, ResponseTrait;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('role:Administrador')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @param ToursDataTable $dataTable
     * @return mixed
     */
    public function index(ToursDataTable $dataTable):mixed
    {
        return $dataTable->render('admin.tour.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create():View
    {
        return view('admin.tour.create')
            ->with('timetables', Timetables::all() )
            ->with('tourTypes', TourType::all() );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request):RedirectResponse
    {
        $this->validateCreateRequest($request);

        DB::beginTransaction();
        try{

            $timetable = Timetables::findOrFail($request->request->getInt('time'));

            $this->creatTour($timetable, Carbon::parse($request->request->get('date')), Auth::user()->id , $request->request->get('info') );

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorResponse('tours.create' , $e->getMessage(), __('app.error_create', ['object' => __('app.tour_singular') ]) );
        }
        return $this->successCreateResponse('tours.index',__('app.tour_singular'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show(int $id):View
    {
        $tour = Tour::findOrFail($id);

        if($tour->state != 1 )
        {
            $this->errorAbort404();
        }

        return view('admin.tour.show')
            ->with('tour',$tour)
            ->with('tourGuides',TourGuides::all()->where('tour','=',$id))
            ->with('guides',Guides::all())
            ->with('typeGuides', GuidesType::all())
            ->with('clients',TourClient::all()->where('tour','=',$id))
            ->with('clientTypes',ClientType::all())
            ->with('selectedGuides',$tour->selectedGuides());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id):View
    {
        $tour = Tour::findOrFail($id);

        if($tour->state != 1 )
        {
            $this->errorAbort404();
        }

        return view('admin.tour.edit')
            ->with('tour',$tour)
            ->with('tourStates', TourState::all())
            ->with('tourTypes', TourType::all())
            ->with('timetables',Timetables::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id):RedirectResponse
    {
        $this->validateUpdateRequest($request);

        DB::beginTransaction();
        try{

            $timetable = Timetables::findOrFail($request->request->getInt('time'));

            $tour = Tour::findOrFail($id);
            $tour->update([
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

            return $this->errorResponse('tours.update' , $e->getMessage(), __('app.error_update', ['object' => __('app.tour_singular') ]) );
        }
        return $this->successUpdateResponse('tours.index', __('app.tour_singular') );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response | JsonResponse
     */
    public function destroy(int $id):Response | JsonResponse
    {
        DB::beginTransaction();
        try{
            $tour = Tour::findOrFail($id);

            if($tour->state != 1 ){
                return $this->errorJsonResponse('', 'Not Found',null , 404);
            }

            $tour->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            return $this->errorDestroyResponse( $e , __('app.error_delete'), 500 );
        }
        return $this->successDestroyResponse(__('app.success'));
    }


}
