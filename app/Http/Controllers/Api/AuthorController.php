<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Facades\Hash;

class AuthorController extends Controller
{
    //REGSITER METHOD - POST
    public function regsiter(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:authors',
            'password' => 'required',
            'phone' => 'required|unique:authors'

        ]);

        $author = new Author();
        $author->name = $request->name;
        $author->email = $request->email;
        $author->password = Hash::make($request->password);
        $author->phone = $request->phone;
        $author->save();

        return response()->json(['status' => 1, 'message' => 'author created succssfully']);

    }

    //LOGIN METHOD - POST
    public function login(Request $request)
    {
        $login_data = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(!auth()->attempt($login_data)){
            return response()->json(['status' => false, 'message' => 'Invalid Credentials']);
        }

        //taoken
        $token = auth()->user()->createToken("auth_token")->accessToken;
        return response()->json(['status' => true, 'message' => 'Auth Logged in succssfully', 'access_token' =>$token]);


    }

    //PROFILE METHOD - GET
    public function profile()
    {
        $user = auth()->user();
        return response()->json(['status' => true, 'message' => 'User Data','data' =>$user]);

    }

     //KOGOUT METHOD - POST
     public function logout(Request $request)
     {
        $token = $request->user()->token();

        $token->revoke();
        return response()->json(['status' => true, 'message' => 'User Logged out succssfully']);

     }


}
