<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserColection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $response = "";
        $token = "";

        $validator = Validator::make($request->all(), [
            'username'  => 'required',
            'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('email', 'password');
        $data =  DB::table('users')->where('username', $request->username)->get();

        if ($user = $data->first()) {
            $pass = Hash::check($request->password, $user->password);
            if ($pass) {
                $response = "sucess";
                $token = env('API_KEY');
            } else {
                $response = "Password Not Valid";
            }
        } else {
            $response = "Username Not Valid";
        }  

        return response()->json([
            "message" => $response,
            "user" => UserColection::collection($data),
            "token" => $token
        ], 200);
    }
}
