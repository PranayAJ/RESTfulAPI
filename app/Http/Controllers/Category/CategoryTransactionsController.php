<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class CategoryTransactionsController extends ApiController
{
    public function index(Category $category)
    {
        $transactions = $category->products()
        ->whereHas('transactions')
        ->with('transactions')
        ->get()
        ->pluck('transactions')
        ->flatten();
    return $this->showAll($transactions);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
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
