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

    public function update($rootValue, array $args, GraphQLContext $context)
    {
        // Check for product ID and input validity
        if (!isset($args['id'])) {
            throw new \Exception("Missing product ID.");
        }

        if (!isset($args['input']) || !is_array($args['input'])) {
            throw new \Exception("Invalid input data.");
        }

        // Find the product
        $product = Product::find($args['id']);
        if (!$product) {
            throw new \Exception("Product not found.");
        }

        // Update product fields
        $input = $args['input'];
        $product->fill($input); // Laravel's fill method for mass assignment
        $product->updated_at = now();
        $product->save();

        return $product;
    }
}
