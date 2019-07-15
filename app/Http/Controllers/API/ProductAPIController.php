<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\APIBaseController as APIBaseController;

use App\Product;
use Validator;

class ProductAPIController extends APIBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       // $products = Product::all();
        $products = Product::latest()->paginate(5);
        return $this->sendResponse($products->toArray(), 'Products retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //metoda 1
//        $input = $request->all();
//        $validator = Validator::make($input, [
//            'name' => 'required',
//            'description' => 'required',
//            'price' => 'required',
//        ]);
//        $file = $request->file('photo');
//
//        if($validator->fails()){
//            return $this->sendError('Validation Error.', $validator->errors());
//        }
//
//
//        $product = Product::create($input);
//        if(!empty($file)) {
//            $imageName = time().'.'.$file->getClientOriginalExtension();
//            $file->move(public_path('images'), $imageName);
//            $data['photo'] = $imageName;
//            $product->update($data);
//        }

        //metoda 2
        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
        $file = $request->file('photo');

        if(!empty($file)) {
            $imageName = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;

        $product->photo = $imageName;
        $product->save();
        return $this->sendResponse($product->toArray(), 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product= Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
}
        return $this->sendResponse($product->toArray(), 'Product retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $product= Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        $product->name = $input['name'];
        $product->description = $input['description'];
        $product->price = $input['price'];
        $product->save();
        return $this->sendResponse($product->toArray(), 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product= Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
//        Product::where('id', $product->id)
//            ->update([
//                'is_delete'=>'0'
//            ]);
        Product::where('id', $product->id)
            ->delete();
        return $this->sendResponse($id, 'Product deleted successfully.');
    }
}
