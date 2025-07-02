<?php

namespace Modules\Products\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Products\App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('products::categories.index');
    }

    public function create()
    {
        return view('products::categories.create');
    }

    public function edit($id)
    {
        return view('products::categories.edit',compact('id'));
    }
}
