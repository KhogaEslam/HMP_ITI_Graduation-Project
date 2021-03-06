<?php

namespace App\Providers;

use App\ProductImage;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

        Route::model("category", \App\Category::class);
        Route::model("product", \App\Product::class);
        Route::model("employee", \App\Employee::class);
        Route::model("cart_detail", \App\CartDetail::class);
        Route::model("item", \App\WishList::class);
        Route::model("featured_request", \App\FeaturedItem::class);
        Route::model("user", \App\User::class);
        Route::model("phone", \App\UserPhone::class);
        Route::model("address", \App\UserAddress::class);
        Route::model("checkout", \App\CartHistory::class);
        Route::model("current_checkout", \App\CurrentCheckout::class);
        Route::model("product_image", \App\ProductImage::class);
        Route::model("shipping_zone", \App\ShippingZone::class);

    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
