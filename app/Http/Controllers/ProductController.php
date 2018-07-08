<?php

namespace App\Http\Controllers;

use App\Exception\ProductNotBelongsToUser;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Requests\ProductRequest;
use App\Model\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class ProductController extends Controller
{
// This Part below is the middleware which helps in protection of the product routes against hackers
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
        //Here We are getting all the product of the api
       return ProductCollection::collection(Product::paginate(20)); 
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
     * Here In The API since we dont use the normal request we got to import the 
     * Product request and add it in the sore function
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        //storing the details in the database
        $product = new Product;

        $product->name = $request->name;
        $product->detail = $request->description;
        $product->stock = $request->stock;
        $product->price = $request->price;
        $product->discount = $request->discount;

        $product->save();

        return response([
        		'data' => new ProductResource($product)
        	],Response::HTTP_CREATED); //The HTTP_CREATED is a response used in laravel to tell you abt the status of an activity
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //Here showing a single detail
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
        $this->ProductUserCheck($product);

        $request['detail'] = $request->description;

        unset($request['description']);

        $product->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response(null,Response::HTTP_NO_CONTENT);
    }

    /**
    *FUnction to check for each user
    */
    public function ProductUserCheck($product)
    {
        if (Auth::id() !== $product->user_id) {
 //the ProductNotBelongsToUser is found in the exception Page           
            throw new ProductNotBelongsToUser;
            
        }
    }
}
