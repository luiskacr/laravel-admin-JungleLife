<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourStateRequest;
use App\Models\TourState;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TourStateController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index():View
    {
        return view('admin.tourState.index')
            ->with('stateTours', TourState::all() );
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function create():View
    {
        return view('admin.tourState.create');
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param TourStateRequest $request
     * @return RedirectResponse
     */
    public function store(TourStateRequest $request):RedirectResponse
    {
        DB::beginTransaction();
        try{
            TourState::create([
                'name'=>$request->request->get('name'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorResponse('tour-state.create' , $e->getMessage(), __('app.error_create', ['object' => __('app.tour_states_singular') ]) );
        }
        return $this->successCreateResponse('tour-state.index',__('app.tour_states_singular'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id):View
    {
        return view('admin.tourState.show')
            ->with('tourState', TourState::findOrFail($id) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id):View
    {
        return view('admin.tourState.edit')
            ->with('tourState',TourState::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TourStateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(TourStateRequest $request,int  $id):RedirectResponse
    {
        DB::beginTransaction();
        try{
            TourState::whereId($id)->update([
                'name'=>$request->request->get('name'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorResponse('tour-state.edit' , $e->getMessage(), __('app.error_update', ['object' => __('app.tour_states_singular') ]) );
        }
        return $this->successUpdateResponse('tour-state.index', __('app.tour_states_singular') );
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
            $tourType = TourState::findOrFail($id);
            $tourType->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorDestroyResponse( $e, __('app.error_delete'), 500 );
        }
        return $this->successDestroyResponse(__('app.success'));
    }
}
