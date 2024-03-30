<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class OrderItem extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'order_items';
    protected $fillable = ['order_id', 'product_id', 'quantity', 'created_at', 'updated_at'];

    // Define relationship to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
