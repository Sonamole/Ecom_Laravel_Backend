<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function category()
    {
        $category=Category::where('status','0')->get();
        return response()->json([
            'status'=>200,
            'category'=>$category,
        ]);

    }

    public function product($slug)
    {
        $category=Category::where('slug',$slug)->where('status','0')->first();
        if($category)
        {
            $product=Product::where('category_id',$category->id)->where('status','0')->get();
            if($product)
            {
                return response()->json([
                    'status'=>200,
                    'product_data'=>[
                        'product'=>$product,
                        'category'=>$category,
                    ]
                ]);
            }
            else{
                return response()->json([
                    'status'=>404,
                    'message'=>'No such Product Available',
                ]);

            }
        }

        else{
            return response()->json([
                'status'=>404,
                'message'=>'No such Category found',
            ]);

        }
    }
}
