<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Blog_Likes extends Model
{
    use HasFactory;

    protected $table = 'blog_likes';

    protected $fillable = ['user_id'];
    protected $appends = ['created_date', 'updated_date'];


    public function likeable()
    {
        return $this->morphTo();
    }

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected function createdDate(): Attribute
    {
        return Attribute::get(function () {
            return $this->created_at ? $this->created_at->format('d/m/Y') : null;
        });
    }

    protected function updatedDate(): Attribute
    {
        return Attribute::get(function () {
            return $this->updated_at ? $this->updated_at->format('d/m/Y') : null;
        });
    }
}
