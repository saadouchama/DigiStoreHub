<?php
use Illuminate\Support\Facades\Route;
use Nuwave\Lighthouse\Support\Http\Controllers\GraphQLController;

Route::middleware(['auth'])->group(function () {
    Route::post('/graphql', [GraphQLController::class, 'query']);
});
