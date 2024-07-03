<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    //
    public function index(){

        $products= product::orderBy('created_at', 'DESC')->get();
        return view('products.list',['products'=>$products]);
    }

    public function create(){

        return view('products.create');
        
    }

    public function store(Request $request){

        $rules=[
            'name' => 'required|min:5'
        ];

        if($request->image !=""){
            $rules['image'] = 'image';
        }


        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }
        //insert db
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();


        if($request->image !=""){
            //store image

            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext; 

            //image to directory
            $image->move(public_path('uploads/products'),$imageName);


            $product->image =$imageName;
            $product->save();
        }


        return redirect()->route('products.index')->with('success','product added successfully');
    }

    public function edit($id){

        $product=Product::findOrFail($id);

        return view('products.edit',['product'=>$product]);
    }

    public function update($id, Request $request){

        $product=Product::findOrFail($id);

        $rules=[
            'name' => 'required|min:5'
        ];

        if($request->image !=""){
            $rules['image'] = 'image';
        }


        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->route('products.edit',$product->id)->withInput()->withErrors($validator);
        }
        //insert db
        
        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();


        if($request->image !=""){

            //del old image
            File::delete(public_path('uploads/products'.$product->image));



            //store image

            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext; 

            //image to directory
            $image->move(public_path('uploads/products'),$imageName);


            $product->image =$imageName;
            $product->save();
        }


        return redirect()->route('products.index')->with('success','product updated successfully');
        
    }

    public function destory($id ){
        
        $product=Product::findOrFail($id);
        File::delete(public_path('uploads/products'.$product->image));

        $product->delete();

        return redirect()->route('products.index')->with('success','product del successfully');

    }
}
