<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Review;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CreateReviewMutation
{
    public function __invoke($rootValue, array $args)
    {
        $validator = Validator::make($args['input'], [
            'productId' => 'required|exists:products,id',
            'userId' => 'required|exists:users,id',
            'text' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        try {

            $review = Review::create([
                'product_id' => $args['input']['productId'],
                'user_id' => $args['input']['userId'],
                'text' => $args['input']['text'],
                'rating' => $args['input']['rating'],
            ]);

            return $review;
        } catch (\Exception $e) {
            Log::error('Review creation failed: ' . $e->getMessage());
            return 'Failed to create the review.';
        }
    }
}
