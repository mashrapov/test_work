<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'user_id', 'product_id', 'category_id'];

    public function Category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function Tags()
    {
        return $this->belongsToMany(Tag::class, ProductTag::class, 'product_id', 'tag_id');
    }
}
