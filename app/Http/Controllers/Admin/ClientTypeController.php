<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientTypeRequest;
use App\Models\ClientType;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ClientTypeController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index():View
    {
        return view('admin.clientType.index')
            ->with('clientTypes', ClientType::all()) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create():View
    {
        return view('admin.clientType.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClientTypeRequest $request
     * @return RedirectResponse
     */
    public function store(ClientTypeRequest $request):RedirectResponse
    {
        DB::beginTransaction();
        try{
            ClientType::create([
                'name'=>$request->request->get('name'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorResponse('type-client.create', $e->getMessage(), __('app.error_create', ['object' => __('app.type_client_singular') ]));
        }
        return $this->successCreateResponse('type-client.index',__('app.type_client_singular'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id):View
    {
        return view('admin.clientType.show')
            ->with('clientType', ClientType::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id):View
    {
        return view('admin.clientType.edit')
            ->with('clientType', ClientType::findOrFail($id) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClientTypeRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(ClientTypeRequest $request,int  $id):RedirectResponse
    {
        DB::beginTransaction();
        try{
            ClientType::whereId($id)->update([
                'name'=>$request->request->get('name'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorResponse('type-client.edit' , $e->getMessage(), __('app.error_update', ['object' => __('app.type_client_singular') ]) );
        }
        return $this->successUpdateResponse('type-client.index', __('app.type_client_singular') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id):Response
    {
        DB::beginTransaction();
        try{
            $clientType = ClientType::findOrFail($id);
            $clientType->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            if ($e->getCode() === '23000') {
                return $this->errorIntegrityHandleResponse();
            }

            return $this->errorDestroyResponse( $e, __('app.error_delete'), 500 );
        }
        return $this->successDestroyResponse(__('app.success'));
    }
}
