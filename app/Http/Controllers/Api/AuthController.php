<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function show()
    {
       $users= User::all();
        return response()->json([
            'status'=>200,
             'users'=>$users,
            'message'=>'All data displayed successfully'
        ]);
    }

    public function register(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|max:191',
            'email'=>'required|max:191|unique:users,email',
            'password'=>'required|min:8',
        ]);

        if($validator->fails()){
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);

        }
        else{

            $user=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]);

           $token=$user->createToken($user->email, ['*'])->plainTextToken;
           return response()->json([
            'status'=>200,
            'username'=>$user->name,
            'token'=>$token,
            'message'=>'Registered Successfully'

        ]);

        }

    }
}
