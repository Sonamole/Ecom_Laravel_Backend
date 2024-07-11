<?php
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product=Product::all();
        return response()->json([
            'status'=>200,
            'products'=>$product,
        ]);
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|max:191',
            'slug' => 'required|max:191',
            'name' => 'required|max:191',
            'meta_title' => 'required|max:191',
            'brand' => 'required|max:20',
            'selling_price' => 'required|max:20',
            'original_price' => 'required|max:20',
            'qty' => 'required|max:4',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $product = new Product;
            $product->category_id = $request->input('category_id');
            $product->slug = $request->input('slug');
            $product->name = $request->input('name');
            $product->description = $request->input('description');

            $product->meta_title = $request->input('meta_title');
            $product->meta_keyword = $request->input('meta_keyword');
            $product->meta_description = $request->input('meta_description');

            $product->brand = $request->input('brand');
            $product->selling_price = $request->input('selling_price');
            $product->original_price = $request->input('original_price');
            $product->qty = $request->input('qty');


            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/product/', $filename);
                $product->image = 'uploads/product/' . $filename;
            }

            //== true: This checks if the value retrieved from the request is true.If the featured input from the request is true, set $product->featured to '1'. If the featured input from the request is not true, set $product->featured to '0'.
            $product->featured = $request->input('featured') == true ? '1' : '0';
            $product->popular = $request->input('popular') == true ? '1' : '0';
            $product->status = $request->input('status') == true ? '1' : '0';
            Log::info('Product Data: ', $product->toArray());
            $product->save();

            return response()->json([
                'status' => 200,
                'check'=>$product,
                'message' => 'Product Added Successfully',
            ]);

        }
    }


    public function edit($id)
    {
        $product=Product::find($id);
        if($product)
        {
            return response()->json([
                'status'=>200,
                'product'=>$product,
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Product  not found'
            ]);
        }
    }



    public function update(Request $request ,$id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|max:191',
            'slug' => 'required|max:191',
            'name' => 'required|max:191',
            'meta_title' => 'required|max:191',
            'brand' => 'required|max:20',
            'selling_price' => 'required|max:20',
            'original_price' => 'required|max:20',
            'qty' => 'required|max:4',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $product = Product::find($id);
            if($product)
            {


            $product->category_id = $request->input('category_id');
            $product->slug = $request->input('slug');
            $product->name = $request->input('name');
            $product->description = $request->input('description');

            $product->meta_title = $request->input('meta_title');
            $product->meta_keyword = $request->input('meta_keyword');
            $product->meta_description = $request->input('meta_description');

            $product->brand = $request->input('brand');
            $product->selling_price = $request->input('selling_price');
            $product->original_price = $request->input('original_price');
            $product->qty = $request->input('qty');


            if ($request->hasFile('image')) {

                $path=$product->image;
                if(File::exists($path))
                {
                    File::delete($path);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/product/', $filename);
                $product->image = 'uploads/product/' . $filename;
            }

            //== true: This checks if the value retrieved from the request is true.If the featured input from the request is true, set $product->featured to '1'. If the featured input from the request is not true, set $product->featured to '0'.
            $product->featured = $request->input('featured') ;
            $product->popular = $request->input('popular') ;
            $product->status = $request->input('status') ;
            Log::info('Product Data: ', $product->toArray());
            $product->update();

            return response()->json([
                'status' => 200,
                'check'=>$product,
                'message' => 'Product Updated Successfully',
            ]);
        }
        else{
            return response()->json([
                'status' => 404,

                'message' => 'Product  not found',
            ]);
        }

        }
    }
}
