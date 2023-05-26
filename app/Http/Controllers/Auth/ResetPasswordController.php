<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class ResetPasswordController extends Controller
{

    /**
     * Display the login view.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Routing\Redirector
     */
    public function show()
    {
        if(Auth::check()){
            return redirect('admin.home');
        }
        return view('auth.passwordReset');
    }


    /**
     * Send to the user the e-mail to reset the password
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $user = User::where('email','=', $request->request->get('email'))->first();

        if($user == null) {

            return redirect()->route('password.request')->with('error',__('app.mail.error'));
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);

    }


    /**
     * Display the Reset Password view.
     *
     * @param Request $request
     * @param $token
     * @return \Illuminate\Contracts\View\View
     */
    public function showReset(Request $request, $token = null)
    {
        return view('auth.reset')->with(['token' => $token, 'email' => $request->email] );
    }


    /**
     * Performs password reset
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email'=> 'required|email',
            'password'=>'required|min:8|confirmed'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
            }
        );
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Verify mail
     *
     * @param Request $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateEmail(Request $request)
    {
        $this->validate($request,['email' => 'required|email']);
    }

}
