<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Storage;

class UploadImagesMutation
{
    public function __invoke($rootValue, array $args)
    {
        $filePaths = [];

        foreach ($args['files'] as $file) {
            // Validate the file, if necessary

            // Store the file and get the path
            $filePath = $file->store('images', 'public');
            $filePaths[] = Storage::disk('public')->url($filePath);
        }

        return $filePaths;
    }
}
