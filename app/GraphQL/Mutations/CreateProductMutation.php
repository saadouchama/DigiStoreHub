<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CreateProductMutation
{
    protected $attributes = [
        'name' => 'createProduct',
    ];

    public function type(): Type
    {
        return Type::nonNull(Type::string());
    }

    public function args(): array
    {
        return [
            'name' => ['name' => 'name', 'type' => Type::nonNull(Type::string())],
            'description' => ['name' => 'description', 'type' => Type::nonNull(Type::string())],
            'price' => ['name' => 'price', 'type' => Type::nonNull(Type::float())],
            'images' => ['name' => 'images', 'type' => Type::nonNull(Type::listOf(Type::string()))],
        ];
    }

    public function resolve($root, $args)
    {
        // Validate the input
        $validator = Validator::make($args, [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'images' => 'required|array'
        ]);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        try {
            $product = Product::create($args);
            return $product->id;
        } catch (\Exception $e) {
            Log::error('Product creation failed: ' . $e->getMessage());
            return 'Failed to create the product.';
        }
    }
}
