<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\NewUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use PHPUnit\Exception;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::all();

        return view('admin.user.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.user.create')->with('roles',$roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try{
            $user = User::create([
                'name' => $request->request->get('name'),
                'email' => $request->request->get('email'),
                'active' => false,
                'password' => $request->request->get('email'),
            ]);

            $role = Role::findById($request->request->getInt('role'));

            $user->assignRole($role);

            $newUser = NewUser::create([
                'email'=> $user->email,
                'token' => Str::random(64),
            ]);

            $newUser->sendMail($user);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            report($e);

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_create', ['object' => __('app.user_singular')]) ;

            return redirect()->route('users.index')->with('message',$message);
        }
        return redirect()->route('users.index')->with('success', __('app.success_create ',['object' => __('app.user_singular')] ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.show')->with('user',$user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        $roles = Role::all();

        return view('admin.user.edit')->with('user',$user)->with('roles',$roles);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id)
    {

        DB::beginTransaction();
        try{
            $user = User::findOrFail($id);

            $user->updateRoleById($request->request->getInt('role'));

            $user->update([
                'name' => $request->request->get('name'),
                'email' => $request->request->get('email'),
                'active' => $request->request->getBoolean('status')
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            app()->hasDebugModeEnabled() ? $message =$e->getMessage() : $message = __('app.error_update', ['object' => __('app.user_singular')]) ;

            return redirect()->route('users.edit',$id)->with('message',$message);
        }
        return redirect()->route('users.index')->with('success',__('app.success_update ',['object' => __('app.user_singular') ]) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $user = User::findOrFail($id);

            $user->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete') ;

            return response($message,500);
        }
        return response( __('app.success'),200);
    }


    /**
     * Function for the administrator to send the password reset email to any user
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function adminResetPassword($id){
        try {

            $user = User::findOrFail($id);

            $status = Password::sendResetLink( [
                'email'=> $user->email,
            ]);

        }catch (Exception $e){

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete') ;

            return response($message,500);
        }
        return response( __('app.success'),200);
    }
}
