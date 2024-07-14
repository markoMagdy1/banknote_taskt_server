<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    use ApiResponseTrait;

    public function get(){
        $products=Product::get();
        return $this->successResponse($products, 'Products returned successfully', 200);
    }

    public function add_product(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse('validation Error', 422, $validator->errors());
        }

        $path = $this->saveImage($request->image, 'products');
        $product=Product::create([
                'title' => $request->title,
                'description' => $request->description,
                'stock' => $request->stock? 1 : 0,
                'image' => $path,
            ]);
        return $this->successResponse($product, 'Product stored successfully', 200);

    }

    public function get_product($id){
        $product=Product::find($id);
        return $this->successResponse($product, 'product returned successfully', 200);
    }

    public function update_product(Request $request,$id){
        $product=Product::find($id);
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }
        if ($request->hasFile('image')) {
            $path = $this->saveImage($request->image, 'products');
        }
        $product->update([
           'title'=>$request->has('title') ? $request->title : $product->title ,
           'descripion'=>$request->has('description') ? $request->description : $product->description,
           'stock'=> $request->has('stock') ? $request->stock : $product->stock,
           'image'=> $request->has('image') ? $path : $product->image,
        ]);

        return $this->successResponse($product, 'product updated successfully', 200);
    }

    public function delete($id){
        Product::where('id',$id)->delete();
        return $this->successResponse([], 'product deleted successfully', 200);
    }
}
