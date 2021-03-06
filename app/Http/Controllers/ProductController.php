<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Requests\ProductRequest;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use App\Exceptions\ProductNotBelongsToUser;
class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return Product::all();
        return  ProductCollection::collection(Product::paginate(10));
        #return new ProductCollection(Product::all()); #if we want to new collection, then return single tiem
        # return ProductResource::collection(Product::all()); #but not want this (All data, want custom data)
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->details = $request->details;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->stock = $request->stock;
        $product->discount = $request->discount;
        $product->user_id = Auth::user()->id;
        $product->save();
        return response([
            'data' => new ProductResource($product)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //return $product;
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        #$request['details'] = $request->description;#only for learn 
        #unset($request['description']);
        $this->ProductUserCheck($product);

        $product->update($request->all());
       
        return response([
            'data' => new ProductResource($product)
        ],Response::HTTP_CREATED);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {   
         $this->ProductUserCheck($product);

        $product->reviewsDeleted();
        $product->delete();
        return response(NULL,Response::HTTP_NO_CONTENT);
    }

    public function ProductUserCheck($product)
    {
        if(Auth::user()->id != $product->user_id)
        {
            throw new ProductNotBelongsToUser;
               
        }
        //return true;
    }


}
