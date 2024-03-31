<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    // Specify your collection if not default 'reviews'
    protected $collection = 'reviews';
    // Fillable, hidden, casts attributes as per your requirements
    protected $fillable = ['product_id', 'user_id', 'comment', 'rating', 'date', 'updated_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
