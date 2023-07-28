<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait;

    /**
     * Response all products
     *
     * @return JsonResponse
     */
    public function getAll()
    {
        $rawProducts = Product::all();
        $products =[];

        foreach($rawProducts as $product){
            if($product->id !=1){
                $products[] = $this->productToArrayConvert($product);
            }
        }

        return $this->successResponse(['products'=> $products ]);
    }

    /**
     * Show a Specific products from his id
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id):JsonResponse
    {
        try {
//            if (!is_int($id)) {
//                throw new \InvalidArgumentException('Invalid ID format. Please provide a valid integer.');
//            }

            $rawProduct = Product::findOrFail($id);

            $product = $this->productToArrayConvert($rawProduct);

            return $this->successResponse(['product'=> $product ]);

        }catch(ModelNotFoundException $e){

            return $this->errorResponse($e, 'Not Found', 404);

        }catch (\InvalidArgumentException $e) {

            return $this->errorResponse($e, 'Bad Request', 400);

        } catch (\Exception $e){

            return $this->errorResponse($e,'Internal ERROR' );
        }
    }

    /**
     * Convert Products for Array Response
     *
     * @param Product $product
     * @return array
     */
    public function productToArrayConvert(Product $product):array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => (double)$product->price,
            'currencies' =>[
                'id' => $product->money,
                'currency' => $product->moneyType->name,
                'symbol' => $product->moneyType->symbol,
            ],
            'categories' =>[
                'id' => $product->type,
                'category' => $product->productType->name,
                'tour_type'=> $product->tourType != null ? [
                    'id' => $product->getTourType->id,
                    'tour' => $product->getTourType->name
                ] : null
            ],

        ];
    }
}
