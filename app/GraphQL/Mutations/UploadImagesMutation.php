<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploadImagesMutation
{
    public function __invoke($rootValue, array $args)
    {
        $filePaths = [];

        foreach ($args['files'] as $file) {
            // Validate the file
            $validator = Validator::make(['file' => $file], [
                'file' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048', // Example validation
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            // Store the file and get the path
            $filePath = $file->store('images', 'public');
            if ($filePath) {
                $filePaths[] = Storage::disk('public')->url($filePath);
            } else {
                throw new \Exception("Failed to store the file.");
            }
        }

        return $filePaths;
    }
}
