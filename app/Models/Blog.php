<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Blog extends Model
{

    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'price'
    ];
}
