<?php

namespace App\GraphQL\Resolvers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class UpdateUserResolver
{
    public function __invoke($rootValue, array $args, GraphQLContext $context)
    {
        // Assuming the user is authenticated and we updating the authenticated user
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            throw new \Exception('No authenticated user found.');
        }

        // Validate and update user data
        $input = $args['input'];

        if (isset($input['email']) && $input['email'] !== $user->email) {
            $validator = Validator::make($args, [
                'email' => 'min:4|max:50|email|unique:users,email',
            ]);

            if ($validator->fails()) {
                return ['message' => $validator->errors()->first()];
            }
        }
        if (isset($input['name']) && $input['name'] !== $user->name) {
            $validator = Validator::make($args, [
                'name' => 'min:3|max:30',
            ]);

            if ($validator->fails()) {
                return ['message' => $validator->errors()->first()];
            }
        }
        // Update user fields
        $user->fill($input);
        $user->save();

        return $user;
    }
}
