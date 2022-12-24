<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\ClientType;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $clients = Customer::all();

        return view('admin.client.index')->with('clients',$clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $clientTypes = ClientType::all();

        return view('admin.client.create')->with('clientTypes',$clientTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClientRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientRequest $request)
    {
        DB::beginTransaction();
        try{
            Customer::create([
                'name' => $request->request->get('name'),
                'email' => $request->request->get('email'),
                'telephone' => $request->request->get('telephone') ,
                'clientType' => $request->request->getInt('clientType') ,
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            app()->hasDebugModeEnabled() ? $message = __('app.error_create', ['object' => __('app.type_client_singular')]) : $message =$e->getMessage();

            return redirect()->route('clients.create')->with('message',$message);
        }
        return redirect()->route('clients.index')->with('success',__('app.success_create ',['object' => __('app.type_client_singular') ] ));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $client = Customer::findOrFail($id);

        return view('admin.client.show')->with('client',$client);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $client = Customer::findOrFail($id);

        $clientTypes = ClientType::all();

        return view('admin.client.edit')->with('client',$client)->with('clientTypes',$clientTypes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClientRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            Customer::whereId($id)->update([
                'name' => $request->request->get('name'),
                'email' => $request->request->get('email'),
                'telephone' => $request->request->get('telephone') ,
                'clientType' => $request->request->getInt('clientType') ,
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            app()->hasDebugModeEnabled() ? $message = __('app.error_update', ['object' => __('app.type_client_singular')]) : $message =$e->getMessage();

            return redirect()->route('clients.edit')->with('message',$message);
        }
        return redirect()->route('clients.index')->with('success',__('app.success_update ',['object' => __('app.type_client_singular') ]) );
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
            $client = Customer::findOrFail($id);
            $client->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            app()->hasDebugModeEnabled() ? $message = __('app.error_delete') : $message = $e->getMessage();

            return response($message,500);
        }
        return response(__('app.success'),200);
    }
}
