<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Order;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CreateStripeCharge
{
    public function __invoke($rootValue, array $args, GraphQLContext $context)
    {

        // Validate input
        $validator = Validator::make($args, [
            'order_id' => 'required|exists:orders,id',
            'source' => 'required',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'message' => $validator->errors()->first()];
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $order = Order::find($args['order_id']);

        try {
            $charge = Charge::create([
                'amount' => $order->total_price * 100, // convert to cents
                'currency' => 'usd',
                'description' => 'Order Payment',
                'source' => $args['source'],
            ]);

            $order->update(['status' => 'paid']); // using Eloquent's update method

            return ['success' => true, 'message' => 'Charge successful', 'charge_id' => $charge->id];
        } catch (ApiErrorException $e) {
            Log::error("Stripe API error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Payment processing failed.'];
        } catch (\Exception $e) {
            Log::error("Error processing payment: " . $e->getMessage());
            return ['success' => false, 'message' => 'An error occurred.'];
        }
    }
}
