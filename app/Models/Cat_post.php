<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat_post extends Model
{
    use HasFactory;
    protected $table = 'cat_post';
    protected $fillable = ['post_id', 'cat_id'];
}
