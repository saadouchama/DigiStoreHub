<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CreateReviewMutation
{

    public function __invoke($rootValue, array $args)
    {

        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            throw new \Exception('Not authenticated');
        }
        $validator = Validator::make($args['input'], [
            'productId' => 'required|exists:products,_id',
            'comment' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        try {

            $review = Review::create([
                'product_id' => $args['input']['productId'],
                'user_id' => $user->id,
                'comment' => $args['input']['comment'],
                'rating' => $args['input']['rating'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $product = Product::find($review->product_id);
            $product->update([
                'average_rating' => $product->averageRating(),
                'ratings_count' => count($product->reviews)
            ]);

            return $review;
        } catch (\Exception $e) {
            Log::error('Review creation failed: ' . $e->getMessage());
            return 'Failed to create the review.';
        }
    }
}
