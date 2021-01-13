<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends ApiController
{
    public function index()
    {
        $products = Tag::all();
        return $this->sendResponse($products->toArray(), 'Список товаров.');
    }
}
