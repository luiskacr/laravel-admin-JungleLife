<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function myProfile(int $id):View
    {
        return view('admin.profile.profile')
            ->with('user',User::findOrFail($id) );
    }


    /**
     * Update profile information
     *
     * @param UpdateUserInfoRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function updateInfo(UpdateUserInfoRequest $request,int $id):RedirectResponse
    {
        DB::beginTransaction();
        try{
            $user = User::findOrFail($id);

            if( auth()->user()->hasRole('Tour Operador') ){
                Customer::where('email', '=', $user->email)
                    ->update(['email' => $request->request->get('email')]);
            }

            $user->update([
                'name'=> $request->request->get('name'),
                'email'=> $request->request->get('email'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_update', ['object' => __('app.profile2')])  ;

            return redirect()->route('myProfile.show',$id)->with('error',$message);
        }
        return redirect()->route('myProfile.show',$id)->with('success',__('app.success_update ',['object' => __('app.profile2') ]) );
    }

    /**
     * Update User Password
     *
     * @param UpdateUserPasswordRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(UpdateUserPasswordRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $user = User::whereId($id);

            if($user->password == bcrypt($request->request->get('current_password'))){
                $user->update([
                    'password'=> $request->request->get('new_password'),
                ]);
            }else{
                $message = __('app.passwords_error');

                return redirect()->route('myProfile.show',$id)->with('error',$message);
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_update', ['object' => __('app.profile2')])  ;

            return redirect()->route('myProfile.show',$id)->with('error',$message);
        }
        return redirect()->route('myProfile.show',$id)->with('success',__('app.success_update ',['object' => __('app.profile2') ]) );
    }


    public function updateImage(Request $request,$id){

        if($request->hasFile('avatar')){
            DB::beginTransaction();
            try{
                $user = User::findOrFail($id);

                if (!empty($user->avatars)) {
                    $previousAvatarPath = $user->avatars;
                    File::delete($previousAvatarPath);
                }

                $file = $request->file('avatar');
                $destinationPath = 'assets/avatars/';

                $filename = time() . '&id=' .$id . '&name=' . $user->name .'.' . $file->extension();
                $uploadSuccess = $request->file('avatar')->move($destinationPath,$filename);

                $user->update([
                    'avatars' => $destinationPath . $filename
                ]);

                DB::commit();
            }catch (\Exception $e){
                DB::rollBack();

                app()->hasDebugModeEnabled() ? $message = $e->getMessage()  : $message = __('app.error_update', ['object' => __('app.profile2')]) ;

                return redirect()->route('myProfile.show',$id)->with('error',$message);
            }
            return redirect()->route('myProfile.show',$id)->with('success',__('app.success_update ',['object' => __('app.profile2') ]) );
        }else{

            $message = __('app.image_error');

            return redirect()->route('myProfile.show',$id)->with('error',$message);
        }
    }

}
