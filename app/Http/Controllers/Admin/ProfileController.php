<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{


    public function myProfile($id){

        $user = User::findOrFail($id);

        return view('admin.profile.profile')->with('user',$user);
    }
}
