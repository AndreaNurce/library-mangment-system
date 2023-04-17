<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Based view composer instead of class based view composer
        View::composer('*', function ($view) {
            // following code will create $categories variable which we can use
            $view->with('categories', Category::orderByDesc('created_at')->get());
        });
    }
}
