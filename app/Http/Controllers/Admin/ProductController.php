<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\MoneyType;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products = Product::all();

        return view('admin.products.index')->with('products',$products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $moneyTypes = MoneyType::all();

        $types = ProductType::all();

        return view('admin.products.create')->with('moneyTypes',$moneyTypes)->with('types',$types);
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        try{
            Product::create([
                'name' =>$request->request->get('name'),
                'description' => $request->request->get('description'),
                'price' => $request->request->getInt('price') ,
                'type' => $request->request->getInt('type'),
                'money' => $request->request->getInt('money'),
            ]);

            DB::commit();
        }catch (\Exception $e){

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_create', ['object' => __('app.tour_states_singular')]) ;

            return redirect()->route('product.create')->with('message',$message);
        }

        return redirect()->route('product.index')->with('success', __('app.success_create ',['object' => __('app.products_singular')] ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.products.show')->with('product',$product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $moneyTypes = MoneyType::all();
        $types = ProductType::all();

        return view('admin.products.edit')->with('product',$product)->with('moneyTypes',$moneyTypes)->with('types',$types);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            Product::whereId($id)->update([
                'name' =>$request->request->get('name'),
                'description' => $request->request->get('description'),
                'price' => $request->request->getInt('price') ,
                'type' => $request->request->getInt('type'),
                'money' => $request->request->getInt('money'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_update', ['object' => __('app.products_singular') ]) ;

            return redirect()->route('product.edit')->with('message',$message);
        }
        return redirect()->route('product.index')->with('success' ,__('app.success_update ',['object' => __('app.products_singular') ]));
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
            $product= Product::findOrFail($id);
            $product->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete');

            return response($message,500);
        }
        return response( __('app.success'),200);
    }

}
