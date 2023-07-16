<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\NewUser;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Schema\ValidationException;

class NewUserController extends Controller
{
    use ResponseTrait;
    /**
     * Validate the Token and Show the view
     *
     * @param Request $request
     * @param null $token
     * @return View
     */
    public function show(Request $request, $token = null):View
    {
        $newUser = NewUser::where('email',$request->email)->first();

        if($newUser == null or $newUser->token != $token){
            $this->errorAbort404();
        }
        return view('auth.newUser')
            ->with('newUser',$newUser);
    }

    /**
     * Ends the user creation process set the password
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException|\Illuminate\Validation\ValidationException
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $this->validateRequest($request);

        $user = User::where('email',$request->email)->first();

        if($user == null)
        {
            return redirect()->route('password.new-user',['token' => $request->token,'email',$request->email] )
                ->with('error',__('app.error_delete'));
        }

        DB::beginTransaction();
        try{

            $user->update([
                'password' => $request->request->get('password'),
                'active' => true
            ]);

            NewUser::where('email',$user->email)->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete') ;

            return redirect()->back()->with('error',$message);
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
    public function validateRequest(Request $request):void
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


}
