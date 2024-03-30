<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;


class Product extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'products';
    protected $fillable = ['name', 'description', 'price', 'category', 'tags', 'images', 'created_at', 'updated_at'];
}
