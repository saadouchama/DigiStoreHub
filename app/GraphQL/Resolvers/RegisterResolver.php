<?php

namespace App\GraphQL\Resolvers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


class RegisterResolver
{
    /**
     * Register a new user.
     *
     * @param null $_
     * @param array $args
     * @param GraphQLContext $context
     * @return array
     */
    public function __invoke($_, array $args, GraphQLContext $context)
    {
        $userData = $args['input'];

        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);

        return $user;
    }
}
