<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'price',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        return asset('storage/blogs/' . $this->image);
    }
    // Define relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
