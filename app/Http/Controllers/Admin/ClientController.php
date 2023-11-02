<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CustomerDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\ClientType;
use App\Models\Configuration;
use App\Models\Customer;
use App\Models\TourClient;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ClientController extends Controller
{
    use ResponseTrait;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('role:Administrador')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @param CustomerDataTable $dataTable
     * @return mixed
     */
    public function index(CustomerDataTable $dataTable):mixed
    {
        return $dataTable->render('admin.client.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create():View
    {
        return view('admin.client.create')
            ->with('clientTypes', ClientType::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClientRequest $request
     * @return RedirectResponse
     */
    public function store(ClientRequest $request):RedirectResponse
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

            return $this->errorResponse('clients.create', $e->getMessage(),  __('app.error_create', ['object' => __('app.customer_single') ]) );
        }
        return $this->successCreateResponse('clients.index',__('app.customer_single'));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return View
     */
    public function show($id):View
    {
        $config = Configuration::findOrFail(4);

        return view('admin.client.show')
            ->with('client', Customer::findOrFail($id) )
            ->with('tourClients', TourClient::where('client', '=', $id)->get() )
            ->with('prefix',$config->data['value']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return View
     */
    public function edit($id):View
    {
        $editEmail = false;
        $costumer = Customer::findOrFail($id);
        $user = User::where('email', '=', $costumer->email)->get();

        if(!$user->isEmpty() and $costumer->clientType == 2){
            $editEmail = true;
        }

        return view('admin.client.edit')
            ->with('client', $costumer )
            ->with('editEmail',$editEmail)
            ->with('clientTypes',ClientType::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClientRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(ClientRequest $request, $id):RedirectResponse
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

            return $this->errorResponse('clients.edit', $e->getMessage(),  __('app.error_update', ['object' => __('app.customer_single')] ));
        }
        return $this->successUpdateResponse('clients.index', __('app.customer_single') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id):Response
    {
        DB::beginTransaction();
        try{

            $client = Customer::findOrFail($id);
            $client->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            return $this->errorDestroyResponse( $e , __('app.error_delete'), 500 );
        }
        return $this->successDestroyResponse(__('app.success'));
    }
}
