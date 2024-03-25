<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Order;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CreateStripeCharge
{
    public function __invoke($rootValue, array $args, GraphQLContext $context)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $orderId = $args['order_id']; // Assuming you pass the order ID
        $order = Order::find($orderId);

        if (!$order) {
            return [
                'success' => false,
                'message' => 'Order not found'
            ];
        }

        try {
            $charge = Charge::create([
                'amount' => $order->total_price * 100,
                'currency' => 'usd',
                'description' => 'Digi Store Hub',
                'source' => $args['source'],
            ]);

            // Update order status upon successful charge
            $order->status = 'paid';
            $order->save();

            return [
                'success' => true,
                'message' => 'Charge successful'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
