<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimetablesRequest;
use App\Models\Timetables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class TimetablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $timetables = Timetables::all();

        return view('admin.timetables.index')->with('timetables', $timetables);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.timetables.create');
    }


    /**
     *  Store a newly created resource in storage.
     *
     * @param TimetablesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TimetablesRequest $request)
    {
        DB::beginTransaction();
        try{

            Timetables::create([
                'start' => Carbon::createFromFormat('H:i:s',$request->request->get('start')),
                'end'=> Carbon::createFromFormat('H:i:s',$request->request->get('end')),
                'auto'=> $request->request->getBoolean('auto')
            ]);

            DB::commit();
        }catch (Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_create', ['object' => __('app.timetables_singular')]) ;

            return redirect()->route('timetable.create')->with('message',$message);
        }

        return redirect()->route('timetable.index')->with('success', __('app.success_create ',['object' => __('app.timetables_singular')] ));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $timetable = Timetables::findOrFail($id);

        return view('admin.timetables.show')->with('timetable',$timetable);
    }


    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $timetable = Timetables::findOrFail($id);

        return view('admin.timetables.edit')->with('timetable',$timetable);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TimetablesRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TimetablesRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            Timetables::whereId($id)->update([
                'start' => Carbon::createFromFormat('H:i:s',$request->request->get('start')),
                'end'=> Carbon::createFromFormat('H:i:s',$request->request->get('end')),
                'auto' => $request->request->getBoolean('auto'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB:DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_update', ['object' => __('app.timetables_singular') ]) ;

            return redirect()->route('timetable.edit')->with('message',$message);
        }

        return redirect()->route('timetable.index')->with('success',__('app.success_update ', ['object' => __('app.timetables_singular') ]));
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
            $timetables = Timetables::findOrFail($id);
            $timetables->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete')  ;

            return response($message,500);
        }
        return response(__('app.success'),200);
    }
}
