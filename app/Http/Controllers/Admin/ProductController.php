<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\MoneyType;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\TourType;
use App\Traits\ResponseTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index():View
    {
        return view('admin.products.index')
            ->with('products',Product::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create():View
    {
        return view('admin.products.create')
            ->with('moneyTypes', MoneyType::all() )
            ->with('types',ProductType::all() )
            ->with('tourTypes',TourType::all() );
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return RedirectResponse
     */
    public function store(ProductRequest $request):RedirectResponse
    {
        DB::beginTransaction();
        try{
            Product::create([
                'name' =>$request->request->get('name'),
                'description' => $request->request->get('description'),
                'price' => $request->request->getInt('price') ,
                'type' => $request->request->getInt('type'),
                'money' => $request->request->getInt('money'),
                'tourType' => $request->request->getInt('tourType') == 0
                    ? null
                    : $request->request->getInt('tourType'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorResponse('product.create' , $e->getMessage(), __('app.error_create', ['object' => __('app.products_singular') ]) );
        }
        return $this->successCreateResponse('product.index',__('app.products_singular'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show(int $id):View
    {
        return view('admin.products.show')
            ->with('product', Product::findOrFail($id) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id):View
    {
        $product = Product::findOrFail($id);

        if($product->price == null)
        {
            $this->errorAbort404();
        }

        return view('admin.products.edit')
            ->with('product',$product )
            ->with('moneyTypes', MoneyType::all() )
            ->with('types', ProductType::all() )
            ->with('tourTypes', TourType::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(ProductRequest $request,int $id):RedirectResponse
    {
        DB::beginTransaction();
        try{

            Product::whereId($id)->update([
                'name' =>$request->request->get('name'),
                'description' => $request->request->get('description'),
                'price' => $request->request->getInt('price') ,
                'type' => $request->request->getInt('type'),
                'money' => $request->request->get('money'),
                'tourType' => $request->request->getInt('type') != 1
                    ? null
                    : $request->request->getInt('tourType')
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorResponse('product.edit' , $e->getMessage(), __('app.error_update', ['object' => __('app.products_singular') ]) );
        }
        return $this->successUpdateResponse('product.index', __('app.products_singular') );
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
            $product= Product::findOrFail($id);

            if($product->price == null)
            {
                return $this->errorDestroyResponse( new \Exception(), __('app.error_delete'), 500 );
            }

            $product->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorDestroyResponse( $e , __('app.error_delete'), 500 );
        }
        return $this->successDestroyResponse(__('app.success'));
    }


}
