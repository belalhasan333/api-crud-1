<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;
use App\Models\SubCategory;

class Category extends Model
{
    protected $fillable = [
        'name',

    ];

    /**
     * Category has many Blogs
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    /**
     * Category has many SubCategories
     */
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
