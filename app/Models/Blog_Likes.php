<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog_Likes extends Model
{
    use HasFactory;

    protected $table = 'blog_likes';

    protected $fillable = ['user_id'];

    public function likeable()
    {
        return $this->morphTo();
    }
}
