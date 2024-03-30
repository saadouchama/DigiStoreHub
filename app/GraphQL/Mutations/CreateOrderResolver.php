<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


class CreateOrderResolver
{
    public function __invoke($rootValue, array $args, GraphQLContext $context)
    {
        try {
            // Create order
            $order = new Order();
            $order->user_id = $args['input']['userId'];
            $order->status = 'pending';
            $order->created_at = now();
            $order->updated_at = now();
            $order->save();

            $total_price = 0;
            $itemsData = [];

            // Fetch product prices
            $productIds = array_column($args['input']['items'], 'productId');
            $products = Product::whereIn('_id', $productIds)->get()->keyBy('_id');

            // Prepare and save items data
            foreach ($args['input']['items'] as $itemInput) {
                $product = $products[$itemInput['productId']];
                $total_price += $itemInput['quantity'] * $product->price;

                $item = new OrderItem([
                    'order_id' => $order->_id, // Use _id for MongoDB
                    'product_id' => $itemInput['productId'],
                    'quantity' => $itemInput['quantity'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $item->save();
            }

            // Update the order with total price
            $order->total_price = $total_price;
            $order->updated_at = now();
            $order->save();

            return $order;
        } catch (\Exception $e) {
            Log::error('Order creation failed: ' . $e->getMessage());
            return 'Failed to create the order.';
        }
    }
}
