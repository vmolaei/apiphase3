<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        //validation
        $request->validate([
            "name"=>"required",
            "email"=>"required|email|unique:users",
            "phone_no"=>"required",
            "password"=>"required|confirmed"

        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_no = $request->phone_no;
        $user->password = bcrypt($request->password);

        //save data

        $user->save();

        //send response
        return response()->json([
            "status"=>1,
            "message"=>"you registered successfully"
        ]);

    }
    public function login(){

    }
    public function profile(){

    }
    public function logout(){

    }
}
