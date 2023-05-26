<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeGuideRequest;
use App\Models\GuidesType;
use Illuminate\Support\Facades\DB;

class TypesGuidesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $typesGuides = GuidesType::all();

        return view('admin.typeGuides.index')->with('typesGuides',$typesGuides);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.typeGuides.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TypeGuideRequest $request
     * @param $atributeEs
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TypeGuideRequest $request)
    {
        DB::beginTransaction();
        try{
            GuidesType::create([
                'name'=>$request->request->get('name'),
            ]);
            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message =$e->getMessage() : $message = __('app.error_update', ['object' => __('app.type_guides_singular')]) ;

            return redirect()->route('type-guides.create')->with('message',$message);
        }
        return redirect()->route('type-guides.index')->with('success', __('app.success_create ',['object' => __('app.type_guides_singular') ] ));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $typesGuide = GuidesType::findOrFail($id);

        return view('admin.typeGuides.show')->with('typesGuide',$typesGuide);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $typesGuide = GuidesType::findOrFail($id);

        return view('admin.typeGuides.edit')->with('typesGuide',$typesGuide);
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param TypeGuideRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TypeGuideRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            GuidesType::whereId($id)->update([
                'name'=>$request->request->get('name'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB:DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_update', ['object' => __('app.type_guides_singular') ])  ;

            return redirect()->route('type-guides.edit')->with('message',$message);
        }
        return redirect()->route('type-guides.index')->with('success' ,__('app.success_update ',['object' => __('app.type_guides_singular') ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        DB::beginTransaction();
        try{
            $clientType = GuidesType::findOrFail($id);
            $clientType->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete') ;

            return response($message,500);
        }
        return response( __('app.success'),200);
    }
}
