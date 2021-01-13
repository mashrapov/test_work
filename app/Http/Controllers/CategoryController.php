<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    public function index()
    {
        $products = Category::all();
        return $this->sendResponse($products->toArray(), 'Список категорий.');
    }
}
