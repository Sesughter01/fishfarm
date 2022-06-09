<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Validator;


class AuthController extends Controller
{
    //
    public function invest(Request $request)
    {
        $validator = Validator::make($request->all(),[
          'name'=>'required|max:191',
          'email'=>'required|email|max:191|unique:users,email'

        ]);

        if($validator->fails()){
            return response()->json([
              'validation_error'=>'Error message not good' 
            ]);
        }
        else{
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
            ]);
        }
        $token = $user->createToken($user->email.'_Token')->plainTextToken;
        return response()->json([
            'status'=>200,
            'username'=>$user->name,
            'token'=>$token,
            'message'=>'Please Check your email for details',
          ]);
    }
}
