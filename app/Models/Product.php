<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;


class Product extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'products';
    protected $fillable = ['name', 'description', 'price', 'category', 'tags', 'images', 'file_path', 'average_rating', 'ratings_count', 'reviews', 'created_at', 'updated_at'];

    public function reviews()
    {
        return $this->hasMany(Review::class);

    }
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

}

