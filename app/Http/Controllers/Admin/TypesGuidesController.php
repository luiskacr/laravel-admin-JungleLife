<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeGuideRequest;
use App\Models\GuidesType;
use App\Models\TourType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypesGuidesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typesGuides = GuidesType::all();

        return view('admin.typeGuides.index')->with('typesGuides',$typesGuides);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.typeGuides.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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

            return redirect()->route('type-guides.create')->with('message',$e->getMessage());
        }
        return redirect()->route('type-guides.index')->with('success','Se ha creado el tipo de Guia');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $typesGuide = GuidesType::findOrFail($id);

        return view('admin.typeGuides.show')->with('typesGuide',$typesGuide);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $typesGuide = GuidesType::findOrFail($id);

        return view('admin.typeGuides.edit')->with('typesGuide',$typesGuide);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

            return redirect()->route('type-guides.edit')->with('message',$e->getMessage());
        }
        return redirect()->route('type-guides.index')->with('success','Se ha actualizado el tipo de Guia');
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
            $clientType = GuidesType::findOrFail($id);
            $clientType->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
            return response($e->getMessage(),500);
        }
        return response('Exitoso',200);
    }
}
