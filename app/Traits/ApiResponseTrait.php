<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Handle the Successful Json Response
     *
     * @param array $response
     * @return JsonResponse
     */
    function successResponse(array $response): JsonResponse
    {
        return  response()->json($response, 200);
    }

    /**
     * Json Response when an error succeeds
     *
     * @param Exception $error
     * @param String $message
     * @param int $status
     * @return JsonResponse
     */
    public function errorResponse(Exception $error, String $message, int $status = 500):JsonResponse
    {
        return response()->json([
            'success' => false,
            'message'=>$this->errorMessageHandle($error, $message)
        ], $status);
    }

    /**
     * Json Response when throw a validation error response.
     *
     * @param array $message
     * @param int $status
     * @return JsonResponse
     */
    public function validationErrorMessage( array $message, int $status = 500):JsonResponse
    {
        return response()->json([
            'success' => false,
            'validation'=>$message
        ], $status);
    }

    /**
     *  Validate if Debug Mode is Enable.
     *
     * @param Exception $error
     * @param String $message
     * @return string
     */
    public function errorMessageHandle(Exception $error, String $message):string
    {
        return app()->hasDebugModeEnabled()
            ? $error->getMessage()
            : $message ;
    }
}
