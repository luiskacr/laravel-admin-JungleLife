<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ExchangeRateDataTable;
use App\Http\Controllers\Controller;
use App\Traits\ExchangeRateTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ExchangeRateController extends Controller
{
    use ExchangeRateTrait,ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @param ExchangeRateDataTable $dataTable
     * @return mixed
     */
    public function index(ExchangeRateDataTable $dataTable):mixed
    {
        return $dataTable->render('admin.exchangeRate.index');
    }

    /**
     * Search for a new Exchange Rate Value
     *
     * @return JsonResponse
     */
    public function searchNewExchangeRate():JsonResponse
    {
        try{

            $this->createExchangeRate();

        }catch (\Exception $e){

            Log::channel('emergency')->error($e->getMessage());

            return $this->errorJsonResponse($e->getMessage(), __('app.error_delete') );
        }
        return $this->successJsonResponse( ['message' => __('app.success') ] );
    }
}
