<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class UploadProductFile
{
    public function __invoke($rootValue, array $args, GraphQLContext $context)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            throw new \Exception('Not authenticated');
        }

        $product = Product::find($args['id']);
        if (!$product) {
            throw new \Exception('Product not found');
        }

        if (isset($args['file'])) {
            $file = $args['file'];
            $validator = Validator::make(['file' => $file], [
                'file' => 'required|file|max:2048', // Example validation
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }
            $filePath = $file->store('private/products', 'local'); // Storing file in private directory

            $product->file_path = $filePath;
            $product->save();

            return $product;
        }

        throw new \Exception('No file provided');
    }
}
