<?php

namespace App\GraphQL\Resolvers;

use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class MeResolver
{
    /**
     * Return the currently authenticated user.
     *
     * @param null $_
     * @param array $args
     * @param GraphQLContext $context
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function __invoke($_, array $args, GraphQLContext $context)
    {
        return Auth::guard('sanctum')->user();
    }
}
