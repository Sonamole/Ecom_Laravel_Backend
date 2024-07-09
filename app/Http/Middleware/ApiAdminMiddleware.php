<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ApiAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Auth::check()) //returns true if the user is logged in, and false otherwise.
        {
            if(auth()->user()->tokenCan('server:admin')) // checks if the authenticated user's token has a specific ability or capability.Abilities (or scopes) are like permissions that can be associated with tokens to restrict access to certain parts of your application.
            {
                return $next($request);
            }

            else{
                return response()->json([

                    'message'=>'Access Denied as your are not an admin'

                ],403);

            }
        }
        else{
            return response()->json([
                'status'=>401,
                'message'=>'Please Login First'

            ]);
        }

    }
}
