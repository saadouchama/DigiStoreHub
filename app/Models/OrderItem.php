<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class OrderItem extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'order_items';

    // Define relationship to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
