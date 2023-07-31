<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'status', 'parent_id'];
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'cat_post', 'cat_id', 'post_id');
    }
}
