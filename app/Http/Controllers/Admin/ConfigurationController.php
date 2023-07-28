<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\PaymentType;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class ConfigurationController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index():View
    {
        return view('admin.configuration.index')
            ->with('configurations',Configuration::all())
            ->with('paymentTypes',PaymentType::all())
            ->with('tokens',PersonalAccessToken::all())
            ->with('users',User::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request):JsonResponse
    {
        DB::beginTransaction();
        try {
            $values = $request->all();
            $count = 1;

            foreach ($values as $value)
            {
                $config = Configuration::findOrFail($count);
                $config->data = [
                    'value' => $value
                ];
                $config->save();
                $count ++;
            }

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            return $this->errorJsonResponse( $e, __('app.error_delete'), 'error' );
        }
        return $this->successJsonResponse(['result' => 'ok']);
    }

    /**
     * Create a REST API Token for user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createToken(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try{
            $user = User::findOrFail( $request->get('user') );
            $token = $user->createToken($request->get('name')) ;

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            return $this->errorJsonResponse( $e, __('app.error_delete'), 'error' );
        }
        return $this->successJsonResponse(['token' => $token->plainTextToken]);
    }

    /**
     * Remove a token from storage.
     *
     * @param int $id
     * @return Response
     */
    public function deleteToken(int $id):Response
    {
        DB::beginTransaction();
        try{
            $token= PersonalAccessToken::findOrFail($id);
            $token->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorDestroyResponse( $e , __('app.error_delete'), 500 );
        }
        return $this->successDestroyResponse(__('app.success'));
    }
}
