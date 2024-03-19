<?php

namespace App\GraphQL\Resolvers;

use App\Models\Product;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CreateProductResolver
{
    public function __invoke($rootValue, array $args, GraphQLContext $context)
    {
        // Create a new product
        $product = new Product();
        $product->name = $args['input']['name'];
        $product->description = $args['input']['description'];
        $product->price = $args['input']['price'];
        $product->category = $args['input']['category'];
        $product->tags = $args['input']['tags'];
        $product->save();

        return $product;
    }
}
