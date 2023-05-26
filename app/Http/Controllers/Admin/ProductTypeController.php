<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductTypeRequest;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $productTypes = ProductType::all();

        return view('admin.productTypes.index')->with('productTypes',$productTypes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.productTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductTypeRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductTypeRequest $request)
    {
        DB::beginTransaction();
        try{
            ProductType::create([
                'name'=>$request->request->get('name'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_update', ['object' => __('app.product_type_singular')])  ;

            return redirect()->route('product-type.create')->with('message',$message);
        }

        return redirect()->route('product-type.index')->with('success', __('app.success_create ',['object' => __('app.tour_type_singular') ] ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $productType = ProductType::findOrFail($id);

        return view('admin.productTypes.show')->with('productType',$productType);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $productType = ProductType::findOrFail($id);

        return view('admin.productTypes.edit')->with('productType',$productType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductTypeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductTypeRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            ProductType::whereId($id)->update([
                'name'=>$request->request->get('name'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_update', ['object' => __('app.product_type_singular') ]) ;

            return redirect()->route('product-type.edit')->with('message',$message);
        }
        return redirect()->route('product-type.index')->with('success' ,__('app.success_update ',['object' => __('app.product_type_singular') ]));
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
            $productType = ProductType::findOrFail($id);
            $productType->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete');

            return response($message,500);
        }
        return response( __('app.success'),200);
    }
}
