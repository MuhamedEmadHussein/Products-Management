<?php

namespace Modules\Products\App\Http\Controllers;

use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return view('products::products.index');
    }

    public function create()
    {
        return view('products::products.create');
    }

    public function edit($id)
    {
        return view('products::products.edit',compact('id'));
    }

}
