<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Product;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Jenssegers\Mongodb\Facades\MongoDB;


class CreateProductMutation
{
    /**
     *@graphql
     *mutation {
     *   createProduct(input: CreateProductInput!): Product! @create
     * }
     */
    public function __invoke($_, array $args): Product
    {
        try {
            return MongoDB::transaction(function () use ($args) {
                $product = new Product([
                    'name' => $args['input']['name'],
                    'description' => $args['input']['description'],
                    'price' => $args['input']['price'],
                    'tags' => $args['input']['tags'],
                    'category' => $args['input']['category'],
                ]);

                $product->save();

                if (!$product->wasRecentlyCreated) {
                    throw new \Exception("Failed to create the product.");
                }

                return $product;
            });
        } catch (\Exception $e) {
            $e->getMessage();
            // Handle transaction failure or exceptions
            // Rollback logic can also be included here
        }
    }
}
