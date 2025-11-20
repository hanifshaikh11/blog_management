<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $appends = ['image_url', 'created_date', 'updated_date'];


    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->morphMany(Blog_Likes::class, 'likeable');
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(function () {
            return $this->image ? url('uploads/blogs/' . $this->image) : null;
        });
    }

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
