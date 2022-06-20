<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductsController extends ApiController
{
    public function index()
    {
        $products = Product::all();
        return $this->showAll($products);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Product $product)
    {
        return $this->showOne($product);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
