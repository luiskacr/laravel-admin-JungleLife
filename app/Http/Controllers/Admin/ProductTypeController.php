<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductTypeRequest;
use App\Models\ProductType;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductTypeController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index():View
    {
        return view('admin.productTypes.index')
            ->with('productTypes', ProductType::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create():View
    {
        return view('admin.productTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductTypeRequest  $request
     * @return RedirectResponse
     */
    public function store(ProductTypeRequest $request):RedirectResponse
    {
        DB::beginTransaction();
        try{
            ProductType::create([
                'name'=>$request->request->get('name'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorResponse('product-type.create', $e->getMessage(), __('app.error_create', ['object' => __('app.product_type_singular') ]));
        }
        return $this->successCreateResponse('product-type.index',__('app.product_type_singular'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show(int $id):View
    {
        return view('admin.productTypes.show')
            ->with('productType', ProductType::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id):View
    {
        return view('admin.productTypes.edit')
            ->with('productType',ProductType::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductTypeRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(ProductTypeRequest $request, int $id):RedirectResponse
    {
        DB::beginTransaction();
        try{
            ProductType::whereId($id)->update([
                'name'=>$request->request->get('name'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorResponse('product-type.edit' , $e->getMessage(), __('app.error_update', ['object' => __('app.product_type_singular') ]) );
        }
        return $this->successUpdateResponse('product-type.index', __('app.product_type_singular') );
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
            $productType = ProductType::findOrFail($id);
            $productType->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorDestroyResponse( $e, __('app.error_delete'), 500 );
        }
        return $this->successDestroyResponse(__('app.success'));
    }
}
