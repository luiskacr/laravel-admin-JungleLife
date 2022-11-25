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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guides = Guides::all();

        return view('admin.guide.index')->with('guides',$guides);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typeGuides = GuidesType::all();

        return view('admin.guide.create')->with('typeGuides',$typeGuides);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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

            return redirect()->route('guides.create')->with('message',$e->getMessage());
        }

        return redirect()->route('guides.index')->with('success','Se ha creado el tipo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

            return redirect()->route('guides.edit')->with('message',$e->getMessage());
        }
        return redirect()->route('guides.index')->with('success','Se ha creado el tipo');
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

            return response($e->getMessage(),500);
        }
        return response('Exitoso',200);
    }
}
