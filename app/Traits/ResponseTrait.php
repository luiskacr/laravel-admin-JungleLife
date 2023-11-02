<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;


trait ResponseTrait
{
    /**
     * Redirect Response route with error message
     *
     * @param String|array $route
     * @param string $error
     * @param String $message
     * @return RedirectResponse
     */
    public function errorResponse(String|array $route,string $error, String $message):RedirectResponse
    {
        return redirect()->route($route)
            ->with('message',$this->errorMessage($error, $message));
    }

    /**
     * Response redirected when creation is successful
     *
     * @param String $route
     * @param String $entity
     * @return RedirectResponse
     */
    public function successCreateResponse(String $route,  String $entity):RedirectResponse
    {
        return redirect()->route($route)
            ->with('success',__('app.success_create ',['object' => $entity ]));
    }

    /**
     * Response redirected when update is successful
     *
     * @param String $route
     * @param String $entity
     * @return RedirectResponse
     */
    public function successUpdateResponse(String $route, String $entity):RedirectResponse
    {
        return redirect()->route($route)
            ->with('success',__('app.success_update ',['object' => $entity ]) );
    }

    /**
     * Json Response when a change is successful
     *
     * @param array $response
     * @param int $status
     * @return JsonResponse
     */
    public function successJsonResponse(array $response,int $status = 200):JsonResponse
    {
        return response()->json($response,$status);
    }

    /**
     * Json Response when an error succeeds
     *
     * @param String|null $type
     * @param String $error
     * @param String $message
     * @param int $status
     * @return JsonResponse
     */
    public function errorJsonResponse(String $error,  String $message, String $type = null, int $status = 500):JsonResponse
    {
        return response()->json(['message'=> (!is_null($type) or $type == 'error')
            ? $this->errorMessage($error, $message)
            : $message
        ], $status);
    }

    /**
     * HTTP Response when delete is successful
     *
     * @param String $message
     * @param int $status
     * @return Response
     */
    public function successDestroyResponse(String $message, int $status = 200):Response
    {
        return response($message, $status);
    }

    /**
     * HTTP Response with error message
     *
     * @param Exception $error
     * @param String $message
     * @param int $status
     * @return Response
     */
    public function errorDestroyResponse(Exception $error, String $message, int $status):Response
    {
        if ($error->getCode() === '23000') {
            return $this->errorIntegrityHandleResponse();
        }

        return response($this->errorMessage($error->getMessage(), $message),$status);
    }

    /**
     * Handle a Integrity Delete Error message
     *
     * @param int $status
     * @return Response
     */
    public function errorIntegrityHandleResponse(int $status = 409):Response
    {
        return response(__('app.error_delete_integrity'), $status);
    }

    /**
     *  Validate if Debug Mode is Enable
     *
     * @param String $error
     * @param String $message
     * @return string
     */
    public function errorMessage(String $error, String $message):string
    {
        return app()->hasDebugModeEnabled()
            ? $error
            : $message ;
    }

    /**
     * Make an abort processes to show 404 page
     *
     * @return void
     */
    public function errorAbort404():void
    {
        abort(404);
    }


}
