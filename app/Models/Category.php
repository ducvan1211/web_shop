<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'status', 'parent_id', 'desc', 'slug', 'cat_feature', 'icon'];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }
    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_category', 'cat_id', 'brand_id');
    }
}
