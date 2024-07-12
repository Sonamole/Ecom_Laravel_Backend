<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Log;
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




    public function viewproduct($category_slug, $product_slug)
    {
        Log::info('Category Slug: ' . $category_slug);
        Log::info('Product Slug: ' . $product_slug);

        $category = Category::where('slug', $category_slug)->where('status', '0')->first();
        if ($category) {
            Log::info('Category found: ' . $category->name);
            $product = Product::where('category_id', $category->id)
                              ->where('slug', $product_slug)
                              ->where('status', '0')
                              ->first();
            if ($product) {
                Log::info('Product found: ' . $product->name);
                return response()->json([
                    'status' => 200,
                    'product' => $product,
                ]);
            } else {
                Log::info('Product not found.');
                return response()->json([
                    'status' => 404,
                    'message' => 'No such Product Available',
                ]);
            }
        } else {
            Log::info('Category not found.');
            return response()->json([
                'status' => 404,
                'message' => 'No such Category found',
            ]);
        }
    }

}
