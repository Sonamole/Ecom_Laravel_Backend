<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    
    public function register(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|max:191',
            'email'=>'required|max:191|unique:users,email',
            'password'=>'required|min:8',
        ]);

        if($validator->fails()){ //checks if the validation fails. The fails() method returns true if the validation did not pass according to the defined rules.
            return response()->json([
                'validation_errors'=>$validator->messages(),// returns a collection of the validation error messages. Each message corresponds to a failed validation rule for an input field.
            ]);

        }
        else{

            $user=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]);
//createToken is a method provided by Laravel's Sanctum package, which is used to generate API tokens.$user is an instance of the User model. The createToken method is called on this user instance to generate a new token.the user's email is used as the token name.The ['*'] value means the token has all abilities (full access).plainTextToken is a property of this instance that contains the actual token string in plain text format.
           $token=$user->createToken($user->email, ['*'])->plainTextToken;
           return response()->json([
            'status'=>200,
            'username'=>$user->name,
            'token'=>$token,
            'message'=>'Registered Successfully'

        ]);

        }

    }

    public function login(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'email'=>'required|max:191',
            'password'=>'required|min:8',
        ]);

        if($validator->fails()){ //checks if the validation fails. The fails() method returns true if the validation did not pass according to the defined rules.
            return response()->json([
                'validation_errors'=>$validator->messages(),// returns a collection of the validation error messages. Each message corresponds to a failed validation rule for an input field.
            ]);

        }

        else{


            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) { //It compares a plain-text password ($request->password) with a hashed password ($user->password) stored in the database.
                    return response()->json([
                        'status'=>401,
                        'message'=>'Invalid Credentials',
                    ]);
            }

            else{

                if($user->role_as ==1) //1=Admin
                {
                   $role='admin';
                   $token= $user->createToken($user->email,['server:admin'])->plainTextToken; //['server:admin'] is an example of an ability. You can define any abilities you need, such as ['read', 'write'], to restrict what actions can be performed with this token.
                }

                else{
                    $role='';
                    $token=$user->createToken($user->email, [''])->plainTextToken;
                }

                return response()->json([
                 'status'=>200,
                 'username'=>$user->name,
                 'token'=>$token,
                 'role'=>$role,
                 'message'=>'Logged in Successfully'

             ]);
            }
    }
}


    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Logout Successfully'


        ]);
    }



}






// 3. How Running composer require laravel/ui and php artisan ui bootstrap Helped?
// Setting Up CSRF: These commands configure your Laravel application to handle CSRF tokens correctly. They ensure that Laravel generates and validates CSRF tokens properly for API requests.

// Syncing Frontend and Backend: By setting up Bootstrap with laravel/ui, it might also update your React frontend to send the CSRF token with requests automatically, ensuring both ends (frontend and backend) are synchronized in handling security tokens.

// Syncing Frontend and Backend:

// What it means: Your website's front part (React) talks to the back part (Laravel). They need to understand each other's security rules.
// What happened: Using laravel/ui with Bootstrap helps React automatically use these security passes (CSRF tokens) when talking to Laravel.
// Why it's good: It keeps your website safe by making sure both sides (front and back) agree on how to stay secure.

// Setting Up CSRF:
// Running composer require laravel/ui and php artisan ui bootstrap helps in setting up the CSRF tokens correctly.
// Syncing frontend (React) and backend (Laravel) ensures that the CSRF tokens are managed correctly for secure communication.
