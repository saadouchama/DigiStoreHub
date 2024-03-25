<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Order;
use App\Models\OrderItem;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CreateOrderResolver
{
    public function __invoke($rootValue, array $args, GraphQLContext $context)
    {
        // Create order
        $order = new Order();
        $order->user_id = $args['input']['userId'];
        $order->status = 'pending'; // default status
        $order->save();
        $total_price = 0;
        // Add items to the order
        foreach ($args['input']['items'] as $itemInput) {
            $item = new OrderItem();
            $item->order_id = $order->id;
            $item->product_id = $itemInput['productId'];
            $item->quantity = $itemInput['quantity'];
            // Optionally calculate price
            $total_price += $item->quantity * $item->product->price;
            $order->update(['total_price' => $total_price]);
            $item->save();
        }

        return $order;
    }
}
