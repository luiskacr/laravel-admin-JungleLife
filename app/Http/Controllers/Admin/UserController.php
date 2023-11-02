<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Customer;
use App\Models\NewUser;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use PHPUnit\Exception;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index():View
    {;
        return view('admin.user.index')
            ->with('users', User::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create():View
    {
        return view('admin.user.create')
            ->with('roles',Role::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request):RedirectResponse
    {
        DB::beginTransaction();
        try{
            $user = User::create([
                'name' => $request->request->get('name'),
                'email' => $request->request->get('email'),
                'active' => false,
                'password' => $request->request->get('email'),
            ]);

            if($request->request->getInt('role') == 3){
                Customer::create([
                    'name' => $request->request->get('name'),
                    'email' => $request->request->get('email'),
                    'telephone' => $request->request->get('telephone') ,
                    'clientType' => 2 ,
                ]);
            }

            $role = Role::findById($request->request->getInt('role'));
            $user->assignRole($role);

            $newUser = NewUser::create([
                'email'=> $user->email,
                'name'=> $user->name,
                'token' => Str::random(64),
            ]);

            $newUser->sendMail();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorResponse('users.index' , $e->getMessage(), __('app.error_create', ['object' => __('app.user_singular') ]) );
        }
        return $this->successCreateResponse('users.index',__('app.user_singular'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show(int $id):View
    {
        return view('admin.user.show')
            ->with('user', User::findOrFail($id) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id):View
    {
        return view('admin.user.edit')
            ->with('user', User::findOrFail($id) )
            ->with('roles', Role::all() );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(UserRequest $request,int  $id):RedirectResponse
    {
        DB::beginTransaction();
        try{
            $user = User::findOrFail($id);

            $user->updateRoleById($request->request->getInt('role'));

            if($request->request->getInt('role') == 3){
                Customer::where('email', '=', $user->email)
                    ->update(['email' => $request->request->get('email')]);
            }

            $user->update([
                'name' => $request->request->get('name'),
                'email' => $request->request->get('email'),
                'active' => $request->request->getBoolean('status')
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            dd($e->getMessage());

            return $this->errorResponse(['users.edit', $id] , $e->getMessage(), __('app.error_update', ['object' => __('app.user_singular') ]) );
        }
        return $this->successUpdateResponse('users.index', __('app.user_singular') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
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

            return $this->errorDestroyResponse( $e, __('app.error_delete'), 500 );
        }
        return $this->successDestroyResponse(__('app.success'));
    }


    /**
     * Function for the administrator to send the password reset email to any user
     *
     * @param int $id
     * @return Response
     */
    public function adminResetPassword(int $id):Response
    {
        try{

            $user = User::findOrFail($id);

            $status = Password::sendResetLink( [
                'email'=> $user->email,
            ]);

        }catch (Exception $e){

            return $this->errorDestroyResponse( $e, __('app.error_delete'), 500 );
        }
        return $this->successDestroyResponse(__('app.success'));
    }
}
