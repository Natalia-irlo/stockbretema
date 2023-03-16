<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController2 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $products = Product::all();
        echo $products;
        return $products;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     $product = new Product();
    //     return view('product.create', compact('product'));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
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
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);

        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // request()->validate(Product::$rules);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $product = Product::find($id)->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
