<?php

namespace App\GraphQL\Resolvers;

use App\Models\Product;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ProductsResolver
{
    public function __invoke($rootValue, array $args, GraphQLContext $context)
    {
        return Product::all();
    }
}
