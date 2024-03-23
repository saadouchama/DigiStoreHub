<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Storage;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


class UploadImagesMutation
{
    protected $attributes = [
        'name' => 'uploadImages',
    ];

    public function type(): Type
    {
        return Type::nonNull(Type::listOf(Type::string()));
    }

    public function args(): array
    {
        return [
            'files' => ['name' => 'files', 'type' => Type::nonNull(Type::listOf(Type::upload()))],
        ];
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context)

    {
        $imageUrls = [];

        foreach ($args['files'] as $file) {
            // Store the uploaded image
            $path = $file->store('products', 'public');
            $imageUrls[] = Storage::url($path);
        }

        return $imageUrls;
    }
}
