<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CreateOrderResolver
{
    public function __invoke($rootValue, array $args, GraphQLContext $context)
    {
        // Start a transaction
        DB::beginTransaction();

        try {
            // Create order
            $order = new Order();
            $order->user_id = $args['input']['userId'];
            $order->status = 'pending';
            $order->save();

            $total_price = 0;
            $itemsData = [];

            // Fetch product prices in one query
            $productIds = array_column($args['input']['items'], 'productId');
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

            // Prepare items data
            foreach ($args['input']['items'] as $itemInput) {
                $product = $products[$itemInput['productId']];
                $total_price += $itemInput['quantity'] * $product->price;

                $itemsData[] = [
                    'order_id' => $order->id,
                    'product_id' => $itemInput['productId'],
                    'quantity' => $itemInput['quantity'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            // Bulk insert order items
            OrderItem::insert($itemsData);

            // Update the order with total price
            $order->total_price = $total_price;
            $order->save();

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Order creation failed: ' . $e->getMessage());
            return 'Failed to create the order.';
        }
    }
}
