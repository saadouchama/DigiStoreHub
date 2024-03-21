<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

final class CreateReview
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($rootValue, array $args)
    {
        // Validate input data
        $validator = Validator::make($args['input'], [
            'productId' => 'required|exists:products,id',
            'userId' => 'required|exists:users,id',
            'text' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
            // Add more validation rules as needed
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        // Create a new review
        $review = Review::create([
            'product_id' => $args['input']['productId'],
            'user_id' => $args['input']['userId'],
            'text' => $args['input']['text'],
            'rating' => $args['input']['rating'],
            // Add other fields as needed
        ]);

        return $review;
    }
}
