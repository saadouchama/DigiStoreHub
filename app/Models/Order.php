<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Order extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'orders';

    // Define relationship to OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
