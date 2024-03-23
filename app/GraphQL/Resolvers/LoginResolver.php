<?php

namespace App\GraphQL\Resolvers;

use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class LoginResolver
{
    public function __invoke($rootValue, array $args, GraphQLContext $context)
    {
        $credentials = $args['input'];

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
        } else {
            throw new \Exception('Invalid credentials');
        }



        return [
            'accessToken' => $token,
            'user' => $user
        ];
    }
}
