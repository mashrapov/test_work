<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends ApiController
{
    public function index(Request $request)
    {
        $products = Product::with('Category')->with('Tags')->with('User');

        // Фильрация полей
        if ($request->fields) {
            $products = $products->select(explode(',', $request->fields));
        }

        try {
            $products = $products->get();
        } catch (\Exception $exception) {
            return $this->sendError($exception->errorInfo[2]);
        }
        return $this->sendResponse($products, 'Список товаров.');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'tag_ids' => 'required|array',
        ]);
        if($validator->fails()){
            return $this->sendError('Ошибка валидации.', $validator->errors());
        }
        $input['user_id'] = Auth::id();
        $product = Product::create($input);
        if ($product) {
            ProductTag::addTagsToProduct($input['tag_ids'], $product->id);
        }
        return $this->sendResponse($product->toArray(), 'Товар создан');
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('user_id', Auth::id())->find($id);

        if(!$product){
            return $this->sendError('Товар не найден');
        }
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'tag_ids' => 'required|array',
        ]);
        if($validator->fails()){
            return $this->sendError('Ошибка валидации.', $validator->errors());
        }
        $product->name = $input['name'];
        $product->category_id = $input['category_id'];
        $product->save();

        ProductTag::where('product_id', $product->id )->delete();
        ProductTag::addTagsToProduct($input['tag_ids'], $product->id);

        return $this->sendResponse($product->toArray(), 'Товар изменен');
    }

    public function show($id)
    {
        $product = Product::with('Category')->with('Tags')->find($id);
        if (is_null($product)) {
            return $this->sendError('Товар не найден');
        }
        return $this->sendResponse($product->toArray(), 'Товар');
    }

    public function destroy($id)
    {
        $product = Product::where('user_id', Auth::id())->find($id);
        if (is_null($product)) {
            return $this->sendError('Товар не найден');
        }
        $product->delete();
        return $this->sendResponse($product->toArray(), 'Товар удален.');
    }
}
