<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\NewUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewUserController extends Controller
{

    /**
     * Validate the Token and Show the view
     *
     * @param Request $request
     * @param $token
     * @return \Illuminate\Contracts\View\View|void
     */
    public function show(Request $request,$token = null)
    {
        $newUser = NewUser::where('email',$request->email)->first();

        if($newUser == null or $newUser->token != $token){
            abort(404);
        }else{
            return view('auth.newUser')->with('newUser',$newUser);
        }
    }

    /**
     * Ends the user creation process set the password
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function resetPassword(Request $request)
    {
        $this->validateRequest($request);

        $user = User::where('email',$request->email)->first();

        if($user == null){

            return redirect()->route('password.new-user',['token' => $request->token,'email',$request->email] )
                ->with('error',__('app.error_delete'));
        }

        DB::beginTransaction();
        try{

            $user->update([
                'password' => $request->request->get('password'),
                'active' => true
            ]);

            $this->deleteNewUser($user->email);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete') ;

            return redirect()->route('type-client.edit')->with('error',$message);
        }

        return redirect()->route('login')->with('message', __('app.welcome_view_success'));
    }

    /**
     * Validate Request Fields
     *
     * @param Request $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateRequest(Request $request)
    {
        $rules = [
            'token' => 'required',
            'email'=> 'required|email',
            'password'=>'required|min:8|confirmed'
        ];

        $attribute = [
            'password'=> __('app.passwords')
        ];

        $this->validate($request, $rules, [], $attribute);
    }


    /**
     * Delete New User Field on the table if the user is created
     *
     * @param $email
     * @return void
     */
    public function deleteNewUser($email)
    {
        $newUser = NewUser::where('email',$email)->first();

        $newUser->delete();
    }

}
