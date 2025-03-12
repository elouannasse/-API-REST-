<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $request->validate([
           'name'=>'required|string|max:255',
            "email"=>'required|email|max:255|unique:users,email',
            'password'=>'required|string|min:8'
             
        ]);
      $user =  User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)

        ]);
        return response()->json([
            'message'=>'user Registed succuful' ,
             'user'=>$user,201
        ]);
    }
    public function login(Request $request){
        
       $request->validate([
         "email"=>'required|email',
         'password'=>'required|string'

       ]);
       if(!Auth::attempt($request->only('email','password'))){
        return response()->json(['messge=>invalide email or password'],401);

       }
      $user = User::where('email',$request->email)->firstOrFail();
     $token = $user->createToken('auth_Token')->plainTextToken;


     return response()->json([
        'message'=>'login succuful' ,
         'user'=>$user,201,
         'Token'=>$token
    ]);
    }
    public function logoute(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message'=>'logout succefull'  ]);




    }
}
