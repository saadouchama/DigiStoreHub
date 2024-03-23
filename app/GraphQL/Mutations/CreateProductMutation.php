<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Jenssegers\Mongodb\Facades\MongoDB;

class CreateProductMutation extends Mutation
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
        // Start a MongoDB transaction
        $session = Product::startSession();
        $session->startTransaction();

        try {
            // Create a new product with images
            $product = Product::create($args);

            // Commit the transaction
            $session->commitTransaction();

            // Return the product ID
            return $product->id;
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            $session->abortTransaction();
            return $e->getMessage();
        }
    }
}
// class CreateProductMutation
// {
//     /**
//      *@graphql
//      *mutation {
//      *   createProduct(input: CreateProductInput!): Product! @create
//      * }
//      */
//     public function __invoke($_, array $args): Product
//     {
//         try {
//             return MongoDB::transaction(function () use ($args) {
//                 $product = new Product([
//                     'name' => $args['input']['name'],
//                     'description' => $args['input']['description'],
//                     'price' => $args['input']['price'],
//                     'tags' => $args['input']['tags'],
//                     'category' => $args['input']['category'],
//                     'images' => $args['input']['images'],

//                 ]);

//                 $product->save();

//                 if (!$product->wasRecentlyCreated) {
//                     throw new \Exception("Failed to create the product.");
//                 }

//                 return $product;
//             });
//         } catch (\Exception $e) {
//             $e->getMessage();
//             // Handle transaction failure or exceptions
//             // Rollback logic can also be included here
//         }
//     }
// }
