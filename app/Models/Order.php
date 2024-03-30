<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Order extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'orders';
    protected $fillable = ['user_id', 'total_price', 'status', 'created_at', 'updated_at'];

    // Define relationship to OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
