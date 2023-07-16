<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;


class ResetPasswordController extends Controller
{

    /**
     * Display the login view.
     *
     * @return View | RedirectResponse
     */
    public function show(): View | RedirectResponse
    {
        if(Auth::check())
        {
            return redirect('admin.home');
        }

        return view('auth.passwordReset');
    }

    /**
     * Send to the user the e-mail to reset the password
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function sendResetLinkEmail(Request $request):RedirectResponse
    {
        $this->validateEmail($request);

        $user = User::where('email','=', $request->request->get('email') )->first();

        if($user == null)
        {
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
     * @return View
     */
    public function showReset(Request $request, $token = null):View
    {
        return view('auth.reset')
            ->with(['token' => $token, 'email' => $request->email ] );
    }

    /**
     * Performs password reset
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function resetPassword(Request $request):RedirectResponse
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
     * Verify mail Format
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    protected function validateEmail(Request $request):void
    {
        $this->validate($request,['email' => 'required|email']);
    }

}
