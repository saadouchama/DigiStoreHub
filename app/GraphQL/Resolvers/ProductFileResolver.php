<?php

namespace App\GraphQL\Resolvers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ProductFileResolver
{
    public function __invoke($rootValue, array $args, GraphQLContext $context)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            throw new \Exception('Not authenticated');
        }

        $productId = $args['id'];
        $product = Product::find($productId);

        if (!$product) {
            throw new \Exception('Product not found');
        }

        // Check if user has purchased the product
        $purchase = $user->orders()->whereHas('items', function ($query) use ($productId) {
                        $query->where('product_id', $productId);
                    })->exists();

        if (!$purchase) {
            throw new \Exception('You do not have permission to download this product');
        }

        // Return the file path or download URL
        return $product->file_path;
    }
}
