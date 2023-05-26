<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourTypeRequest;
use App\Models\MoneyType;
use App\Models\TourType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $tourTypes = TourType::all();

        return view('admin.tourTypes.index')->with('tourTypes',$tourTypes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $moneyTypes = MoneyType::all();

        return view('admin.tourTypes.create')->with('moneyTypes',$moneyTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TourTypeRequest $request
     * @param $atributeEs
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TourTypeRequest $request)
    {
        DB::beginTransaction();
        try{
            TourType::create([
                'name'=>$request->request->get('name'),
                'money'=>$request->request->getInt('money'),
                'fee1'=>$request->request->getInt('fee1'),
                'fee2'=>$request->request->get('fee2'),
                'fee3'=>$request->request->get('fee3'),
                'fee4'=>$request->request->get('fee4'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_update', ['object' => __('app.tour_type_singular')])  ;

            return redirect()->route('tour-type.create')->with('message',$message);
        }
        return redirect()->route('tour-type.index')->with('success', __('app.success_create ',['object' => __('app.tour_type_singular') ] ));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $tourType = TourType::findOrFail($id);

        return view('admin.tourTypes.show')->with('tourType',$tourType);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $tourType = TourType::findOrFail($id);

        $moneyTypes = MoneyType::all();

        return view('admin.tourTypes.edit')->with('tourType',$tourType)->with('moneyTypes',$moneyTypes);
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param TourTypeRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TourTypeRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            TourType::whereId($id)->update([
                'name'=>$request->request->get('name'),
                'money'=>$request->request->getInt('money'),
                'fee1'=>$request->request->getInt('fee1'),
                'fee2'=>$request->request->get('fee2'),
                'fee3'=>$request->request->get('fee3'),
                'fee4'=>$request->request->get('fee4'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_update', ['object' => __('app.tour_type_singular') ]) ;

            return redirect()->route('tour-type.edit')->with('message',$message);
        }
        return redirect()->route('tour-type.index')->with('success' ,__('app.success_update ',['object' => __('app.tour_type_singular') ]));
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
            $tourType = TourType::findOrFail($id);
            $tourType->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete');

            return response($message,500);
        }
        return response( __('app.success'),200);
    }
}
