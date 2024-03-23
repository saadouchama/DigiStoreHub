<?php

namespace App\GraphQL\Resolvers;

use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class LogoutResolver
{
    /**
     * Logout a user by revoking their token.
     *
     * @param null $_
     * @param array $args
     * @param GraphQLContext $context
     * @return bool
     */
    public function __invoke($_, array $args, GraphQLContext $context)
    {
        $user = Auth::guard('sanctum')->user();

        if ($user) {
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            return true;
        }

        return false;
    }
}
