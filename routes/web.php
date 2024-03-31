<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});
Route::get('/checkout', function () {
    return view('checkout');
});
Route::get('/product-file/{productId}', function ($productId) {
    $user = Auth::guard('sanctum')->user();

    if (!$user) {
        abort(403, 'Not Authorized');
    }

    $product = Product::find($productId);

    // Check if the product exists and if the user has permission
    if ($product && $user->hasPurchased($product)) {
        $filePath = $product->file_path;

        if (Storage::exists($filePath)) {
            return Response::file(Storage::path($filePath));
        } else {
            abort(404, 'File not found');
        }
    } else {
        abort(403, 'Access denied');
    }
})->middleware(['auth:sanctum']);

require __DIR__.'/auth.php';
