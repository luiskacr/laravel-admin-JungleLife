<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourStateRequest;
use App\Models\TourState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $stateTours = TourState::all();

        return view('admin.tourState.index')->with('stateTours',$stateTours);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.tourState.create');
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param TourStateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TourStateRequest $request)
    {
        DB::beginTransaction();
        try{
            TourState::create([
                'name'=>$request->request->get('name'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_create', ['object' => __('app.tour_states_singular')]) ;

            return redirect()->route('tour-state.create')->with('message',$message);
        }

        return redirect()->route('tour-state.index')->with('success', __('app.success_create ',['object' => __('app.tour_states_singular')] ));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $tourState = TourState::findOrFail($id);

        return view('admin.tourState.show')->with('tourState',$tourState);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $tourState = TourState::findOrFail($id);

        return view('admin.tourState.edit')->with('tourState',$tourState);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TourStateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TourStateRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            TourState::whereId($id)->update([
                'name'=>$request->request->get('name'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB:DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_update', ['object' => __('app.tour_states_singular') ]) ;

            return redirect()->route('tour-state.edit')->with('message',$message);
        }

        return redirect()->route('tour-state.index')->with('success',__('app.success_update ', ['object' => __('app.tour_states_singular') ]));
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
            $tourType = TourState::findOrFail($id);
            $tourType->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete')  ;

            return response($message,500);
        }
        return response(__('app.success'),200);
    }
}
