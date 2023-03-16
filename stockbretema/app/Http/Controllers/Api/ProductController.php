<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return $products;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // creamos una instancia del modelo producto
        $product = new Product();

        // asignamos al objeto product los valores correspondientes de $request (objeto que viene del form de frontend)
        $product->name=$request->name;
        $product->description=$request->description;
        $product->stock=$request->stock;
        
        //guardamos el objeto product en la db
        $product->save();

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);

        return $product;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $product->update($request->all());

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       
        $product = Product::find($id)->delete();

        return $product;
    
    }
}
