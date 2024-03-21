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
            MongoDB::transaction(function () {
                $product = new Product([
                    'name' => $args['input']['name'],
                    'description' => $args['input']['description'],
                    'price' => $args['input']['price'],
                    'tags' => $args['input']['tags'],
                    'catergory' => $args['input']['catergory'],
                ]);

                    $product->save();

                    return $product;
                });
        } catch (\Exception $e) {
            // Handle transaction failure or exceptions
            // Rollback logic can also be included here
        }
    }
}
