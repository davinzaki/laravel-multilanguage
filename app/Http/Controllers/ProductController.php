<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Products/Products');
    }

    public function getData()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function createData(Request $request)
    {
        Product::create($request->all());

        $request->validate([
            'name' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);
        Product::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        return response()->json('Product created!');
    }

    public function updateData($id, Request $request)
    {

        $product = Product::find($id);
        $product->update($request->all());

        return response()->json('Product updated!');
    }

    public function deleteData($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json('Product deleted!');
    }
}
