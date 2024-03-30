<?php

namespace App\GraphQL\Resolvers;

use App\Models\Product;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CreateProductResolver
{
    public function __invoke($rootValue, array $args, GraphQLContext $context)
    {
        // Check if 'input' key exists and has the expected fields
        if (!isset($args['input']) || !is_array($args['input'])) {
            throw new \Exception("Invalid input data.");
        }

        $input = $args['input'];

        // Create a new product
        $product = new Product();
        $product->name = $input['name'] ?? null;
        $product->description = $input['description'] ?? null;
        $product->price = $input['price'] ?? null;
        $product->category = $input['category'] ?? null;
        $product->tags = $input['tags'] ?? null;
        $product->images = $input['images'] ?? null;
        $product->created_at = now();
        $product->updated_at = now();
        $product->save();

        if (!$product->wasRecentlyCreated) {
            throw new \Exception("Failed to create the product.");
        }

        return $product;
    }
}
