<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'desc', 'content', 'status', 'user_id', 'img'];
    public function categories()
    {
        return $this->belongsToMany(CategoryPost::class, 'cat_post', 'post_id', 'cat_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
