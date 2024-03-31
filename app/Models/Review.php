<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Review extends Model
{

    protected $connection = 'mongodb';
    // Specify your collection if not default 'reviews'
    protected $collection = 'reviews';
    // Fillable, hidden, casts attributes as per your requirements
    protected $fillable = ['product_id', 'user_id', 'comment', 'rating', 'created_at', 'updated_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
