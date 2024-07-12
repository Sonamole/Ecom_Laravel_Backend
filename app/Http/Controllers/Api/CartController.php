<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addtoCart(Request $request)
    {
        //auth('sanctum'): This is using Laravel's authentication system with the Sanctum driver. Sanctum is a Laravel package used for API authentication.
        // check(): This method checks if the user is authenticated. It returns true if a user is logged in and authenticated, and false otherwise.
        if(auth('sanctum')->check())
        {
            $user_id=auth('sanctum')->user()->id;
            $product_id=$request->product_id;
            $product_qty=$request->product_qty;

            $productCheck=Product::where('id',$product_id)->first();

            if($productCheck)
            {
                if(Cart::where('product_id',$product_id)->where('user_id',$user_id)->exists())
                {
                    return response()->json([
                        'status'=>409,
                        'message'=>$productCheck->name,'Already added to cart',
                    ]);

                }

                else{
                    $cartitem=new Cart();
                    $cartitem->user_id=$user_id;
                    $cartitem->product_id=$product_id;
                    $cartitem->product_qty=$product_qty;
                    $cartitem->save();

                    return response()->json([
                        'status'=>201,
                        'message'=>'Added to cart',
                    ]);

                }

            }
            else{

                return response()->json([
                    'status'=>404,
                    'message'=>'Product NOt Found',
                ]);

            }


        }

        else{
            return response()->json([
                'status'=>401,
                'message'=>'Login in to add to cart',
            ]);
        }
    }

    public function viewcart()
    {
        if(auth('sanctum')->check())
        {
            $user_id=auth('sanctum')->user()->id;
            $cartitems=Cart::where('user_id',$user_id)->get();
            return response()->json([
                'status'=>200,
                'cart'=>$cartitems,
            ]);


        }

        else
        {
            return response()->json([
                'status'=>401,
                'message'=>'Login in to View cart data',
            ]);
        }
    }


    public function updatequantity($cart_id, $scope)
{
    if(auth('sanctum')->check()) {
        $user_id = auth('sanctum')->user()->id;
        $cartitem = Cart::where('id', $cart_id)->where('user_id', $user_id)->first();

        if($cartitem) {// Check if the cart item exists
            // Increment the product quantity if scope is "inc" and the quantity is less than 10
            if($scope == "inc" && $cartitem->product_qty < 10) {
                $cartitem->product_qty += 1;
                 // Decrement the product quantity if scope is "dec" and the quantity is greater than 1
            } else if($scope == "dec" && $cartitem->product_qty > 1) {
                $cartitem->product_qty -= 1;
            }

            $cartitem->update();
            return response()->json([
                'status' => 200,
                'message' => 'Quantity updated',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Cart item not found',
            ]);
        }
    } else {
        return response()->json([
            'status' => 401,
            'message' => 'Login to continue',
        ]);
    }
}


    public function deleteCartitem($cart_id)
    {
        if(auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $cartitem = Cart::where('id', $cart_id)->where('user_id', $user_id)->first();

            if($cartitem)
            {
                $cartitem->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Cart Item removed successfully',
                ]);
            }
            else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Cart Item not found',
                ]);
            }

        }

        else
        {
            return response()->json([
                'status' => 401,
                'message' => 'Login to continue',
            ]);
        }


    }

}
