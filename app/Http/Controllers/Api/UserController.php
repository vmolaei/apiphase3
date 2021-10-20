<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


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
    public function login(Request $request){
        //validation
        $request->validate([
            "email"=>"required|email",
            "password"=>"required"
        ]);
        //verify user + token
        if(!$token=auth()->attempt(["email"=>$request->email,"password"=>$request->password])){
            return response()->json([
                "status"=>0,
                "message"=>"Invalid credentionals"
            ]);
        }
        //send response
        return response()->json([
            "status"=>1,
            "message"=>"you logged in successfully",
            "access_token"=>$token
        ]);

    }
    public function profile(){
        $user_data = auth()->user();
                return response()->json([
                    "status" => 1,
                    "message" => "Your profile",
                    "data"=>$user_data
                    ]);


    }
    public function logout(){
        auth()->logout();
        return response()->json([
            "status"=>1,
            "message"=>"user logged out successfully"
        ]);

    }
}
