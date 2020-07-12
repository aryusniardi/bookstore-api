<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'image', 'status'
    ];

    public function books() {
        return $this->belongsToMany('App\Models\Book', 'book_category', 'category_id', 'book_id');
    }
}
