<?php

namespace App\GraphQL\Resolvers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class RegisterResolver
{

    public function __invoke($_, array $args, GraphQLContext $context)
    {
        $userData = $args['input'];

        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return [
            'accessToken' => $token,
            'user' => $user
        ];
    }
}
