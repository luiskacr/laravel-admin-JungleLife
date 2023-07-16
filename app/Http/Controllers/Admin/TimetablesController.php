<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimetablesRequest;
use App\Models\Timetables;
use App\Models\TourType;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class TimetablesController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index():View
    {
        return view('admin.timetables.index')
            ->with('timetables', Timetables::all() );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create():View
    {
        return view('admin.timetables.create')
            ->with('tourTypes', TourType::all());
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param TimetablesRequest $request
     * @return RedirectResponse
     */
    public function store(TimetablesRequest $request):RedirectResponse
    {
        DB::beginTransaction();
        try{
            Timetables::create([
                'start' => Carbon::createFromFormat('H:i:s',$request->request->get('start')),
                'end'=> Carbon::createFromFormat('H:i:s',$request->request->get('end')),
                'auto'=> $request->request->getBoolean('auto'),
                'type' => $request->request->getInt('tourType'),
            ]);

            DB::commit();
        }catch (Exception $e){
            DB::rollback();

            return $this->errorResponse('timetable.create' , $e->getMessage(), __('app.error_create', ['object' => __('app.timetables_singular') ]) );
        }
        return $this->successCreateResponse('timetable.index',__('app.timetables_singular'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id):View
    {
        return view('admin.timetables.show')
            ->with('timetable',Timetables::findOrFail($id) );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id):View
    {
        return view('admin.timetables.edit')
            ->with('timetable', Timetables::findOrFail($id) )
            ->with("tourTypes", TourType::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TimetablesRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(TimetablesRequest $request, int $id):RedirectResponse
    {
        DB::beginTransaction();
        try{
            Timetables::whereId($id)->update([
                'start' => Carbon::createFromFormat('H:i:s',$request->request->get('start')),
                'end'=> Carbon::createFromFormat('H:i:s',$request->request->get('end')),
                'auto' => $request->request->getBoolean('auto'),
                'type' => $request->request->getInt('tourType'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB:DB::rollback();

            return $this->errorResponse('timetable.edit' , $e->getMessage(), __('app.error_update', ['object' => __('app.timetables_singular') ]) );
        }
        return $this->successUpdateResponse('timetable.index', __('app.timetables_singular') );
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
            $timetables = Timetables::findOrFail($id);
            $timetables->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorDestroyResponse( $e, __('app.error_delete'), 500 );
        }
        return $this->successDestroyResponse(__('app.success'));
    }
}
