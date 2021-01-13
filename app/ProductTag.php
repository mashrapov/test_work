<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    protected $fillable = ['product_id', 'tag_id'];

    public static function addTagsToProduct($tags, $product_id)
    {
        foreach ($tags as $tag) {
            ProductTag::create(['product_id' => $product_id, 'tag_id' => $tag]);
        }
    }
}
