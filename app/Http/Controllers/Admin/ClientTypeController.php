<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientTypeRequest;
use App\Models\ClientType;
use Illuminate\Support\Facades\DB;

class ClientTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $clientTypes = ClientType::all();

        return view('admin.clientType.index')->with('clientTypes',$clientTypes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.clientType.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClientTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientTypeRequest $request)
    {

        DB::beginTransaction();
        try{
            ClientType::create([
                'name'=>$request->request->get('name'),
                'rate'=>$request->request->getInt('rate'),
            ]);

            DB::commit();
        }catch (\Exception $e){

            DB::rollback();

            return redirect()->route('type-client.create')->with('message',$e->getMessage());
        }
        return redirect()->route('type-client.index')->with('success','Se ha creado el tipo');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $clientType = ClientType::findOrFail($id);

        return view('admin.clientType.show')->with('clientType',$clientType);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $clientType = ClientType::findOrFail($id);

        return view('admin.clientType.edit')->with('clientType',$clientType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClientTypeRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientTypeRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            ClientType::whereId($id)->update([
                'name'=>$request->request->get('name'),
                'rate'=>$request->request->getInt('rate'),
            ]);

            DB::commit();
        }catch (\Exception $e){

            DB::rollback();

            return redirect()->route('type-client.edit')->with('message',$e->getMessage());
        }
        return redirect()->route('type-client.index')->with('success','Se ha creado el tipo');
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
            $clientType = ClientType::findOrFail($id);
            $clientType->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
            return response($e->getMessage(),500);
        }
        return response('Exitoso',200);
    }
}
