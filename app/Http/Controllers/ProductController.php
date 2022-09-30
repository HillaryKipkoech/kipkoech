<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::latest()->paginate(5);

        return view('products.index', compact('data'))->with('i', (request()->input('page', 1) - 1) * 5);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("products.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name'          =>  'required',
            'product_category'         =>  'required',
            'product_image'         =>  'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
            'product_price'         =>  'required |min: 2'
        ]);

        $file_name = time() . '.' . request()->product_image->getClientOriginalExtension();

        request()->product_image->move(public_path('images'), $file_name);

        $product = new Product;

        $product->product_name = $request->product_name;
        $product->product_category = $request->product_category;
        $product->product_image = $file_name;
        $product->product_price = $request->product_price;

        $product->save();

        return redirect()->route('products.index')->with('success', 'product Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name'          =>  'required',
            'product_category'         =>  'required',
            'product_image'         =>  'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
            'product_price'         =>  'required |min: 2'
        ]);

        $product_image = $request->hidden_product_image;

        if($request->product_image != '')
        {
            $product_image = time() . '.' . request()->product_image->getClientOriginalExtension();

            request()->product_image->move(public_path('images'), $product_image);
        }

        $product = Product::find($request->hidden_id);

        $product->product_name = $request->product_name;

        $product->product_category = $request->product_category;

        $product->product_price = $request->product_price;
        $product->product_image = $product_image;
        $product->save();
        return redirect()->route('products.index')->with('success', 'product Data has been updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'products Data deleted successfully');
    }
}
