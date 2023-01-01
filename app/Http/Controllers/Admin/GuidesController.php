<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuideRequest;
use App\Models\Guides;
use App\Models\GuidesType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Builder;

class GuidesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $guides = Guides::all();

        return view('admin.guide.index')->with('guides',$guides);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $typeGuides = GuidesType::all();

        return view('admin.guide.create')->with('typeGuides',$typeGuides);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GuideRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GuideRequest $request)
    {
        DB::beginTransaction();
        try{
            Guides::create([
                'name' => $request->request->get('name') ,
                'lastName' => $request->request->get('lastName'),
                'type' => $request->request->getInt('type'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_create', ['object' =>  __('app.guide_singular')]) ;

            return redirect()->route('guides.create')->with('message',$message);
        }

        return redirect()->route('guides.index')->with('success',__('app.success_create ',['object' => __('app.guide_singular')] ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $guide = Guides::findOrFail($id);

        return view('admin.guide.show')->with('guide',$guide);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $guide = Guides::findOrFail($id);

        $typeGuides = GuidesType::all();

        return view('admin.guide.edit')->with('guide',$guide)->with('typeGuides',$typeGuides);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GuideRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(GuideRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            Guides::whereId($id)->update([
                'name' => $request->request->get('name') ,
                'lastName' => $request->request->get('lastName'),
                'type' => $request->request->getInt('type'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_update', ['object' =>  __('app.guide_singular')]) ;

            return redirect()->route('guides.edit')->with('message',$message);
        }
        return redirect()->route('guides.index')->with('success',__('app.success_update ', ['object' => __('app.guide_singular') ]));
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
            $guide = Guides::findOrFail($id);
            $guide->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete') ;

            return response($message,500);
        }
        return response(__('app.success'),200);
    }
}
