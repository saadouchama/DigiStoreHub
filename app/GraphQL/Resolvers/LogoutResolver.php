<?php

namespace App\GraphQL\Resolvers;

use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
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
        // Get the authenticated user
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return 'Not authenticated';
        }

        // Revoke the user's current token
        $user->currentAccessToken()->delete();

        return true;
    }
}
