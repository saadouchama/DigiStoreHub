<?php

namespace App\Providers;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('product', function ($app) {
            return new ProductResolver();
        });

        $this->app->bind('products', function ($app) {
            return new ProductsResolver();
        });

        $this->app->bind('createProduct', function ($app) {
            return new CreateProductResolver();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
