<?php

namespace App\GraphQL\Resolvers;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


class LoginResolver
{
    public function __invoke($rootValue, array $args, GraphQLContext $context)
    {
        $credentials = $args['input'];

        if (!Auth::guard('web')->attempt(['email' => $credentials['email'], 'password' => Hash::make($credentials['password'])])) {
            throw new \Exception('Invalid credentials');
        }

        $user = Auth::user();

        // Issue a token
        $token = $user->createToken('authToken')->plainTextToken;

        return [
            'accessToken' => $token,
            'user' => $user,
        ];
    }
}
