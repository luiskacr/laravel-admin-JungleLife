<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class ProfileController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function myProfile($id)
    {

        $user = User::findOrFail($id);

        return view('admin.profile.profile')->with('user',$user);
    }


    /**
     * Update profile information
     *
     * @param UpdateUserInfoRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateInfo(UpdateUserInfoRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            User::whereId($id)->update([
                'name'=> $request->request->get('name'),
                'email'=> $request->request->get('email'),
            ]);

            DB::commit();
        }catch (Exception $e){
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
                $user = User::whereId($id);


                $file = $request->file('avatar');
                $destinationPath = 'assets/avatars/';

                $filename = time() . '-id=' .$id . '-name=' . $file->getClientOriginalName();
                $uploadSuccess = $request->file('avatar')->move($destinationPath,$filename);

                $user->update([
                    'avatar' => $destinationPath . $filename
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
