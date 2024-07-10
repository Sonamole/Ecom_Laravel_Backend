<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $category=Category::all();
        return response()->json([
            'status'=>200,
            'category'=>$category,
        ]);
    }



    public function store(Request $request)
    {

        $validator=Validator::make($request->all(),
        [
            'meta_title'=>'required|max:191',
            'slug'=>'required|max:191',
            'name'=>'required|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);

        }
        else{

        }

       $category=new Category;
       $category->meta_title=$request->input('meta_title');//// Assign the value of 'meta_title' from the request input to the 'meta_title' attribute of the $category object
       $category->meta_keyword=$request->input('meta_keyword');
       $category->meta_description=$request->input('meta_description');
       $category->slug=$request->input('slug');
       $category->name=$request->input('name');
       $category->description=$request->input('description');
       $category->status=$request->input('status');
       $category->save();
       return response()->json([
        'status'=>200,
        'message'=>'Category created successfully',
       ]);


    }

    public function edit($id)
    {
        $category=Category::find($id);
        if($category)
        {
            return response()->json([
                'status'=>200,
                'category'=>$category,
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Category ID not found'
            ]);
        }
    }

    public function update(Request $request ,$id)
    {
        $validator=Validator::make($request->all(),
        [
            'meta_title'=>'required|max:191',
            'slug'=>'required|max:191',
            'name'=>'required|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);

        }
        else{
            $category= Category::find($id);

            if($category)
            {
             $category->meta_title=$request->input('meta_title');//// Assign the value of 'meta_title' from the request input to the 'meta_title' attribute of the $category object
             $category->meta_keyword=$request->input('meta_keyword');
             $category->meta_description=$request->input('meta_description');
             $category->slug=$request->input('slug');
             $category->name=$request->input('name');
             $category->description=$request->input('description');
             $category->status=$request->input('status');
             $category->save();
             return response()->json([
              'status'=>200,
              'message'=>'Category updated successfully',
             ]);

            }
            else{
                return response()->json([
                    'status'=>404,
                    'message'=>'No category Id found',
                   ]);

            }


        }



    }

    public function destroy($id)
    {

        $category=Category::find($id);
        $category->delete();
        if($category)
        {
            return response()->json([
                'status'=>200,
                'message'=>'Category deleted successfully',
               ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'No category Id found',
               ]);
        }
    }
}
