<?php

namespace App\GraphQL\Resolvers;

use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Nuwave\Lighthouse\Exceptions\AuthorizationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ProductResolver
{
    public function __invoke($rootValue, array $args, GraphQLContext $context)
    {
        // if (Gate::denies('access-products')) {
        //     throw new AuthorizationException('You are not authorized to access products.');
        // }

        return Product::findOrFail($args['id']);
    }
}
