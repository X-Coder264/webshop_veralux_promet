<?php

declare(strict_types=1);

namespace App\Providers;

use App\Order;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        view()->composer('partials.navigation', function ($view) {
            $visitor = Cookie::get('unique_id');
            if (null === $visitor) {
                $number_of_products_in_cart = 0;
            } else {
                if (Cache::has($visitor . '.number_of_products_in_cart')) {
                    $number_of_products_in_cart = Cache::get($visitor . '.number_of_products_in_cart');
                } else {
                    $productIDs = Cookie::get('cart_product_IDs');
                    if (null !== $productIDs) {
                        $array = unserialize($productIDs);
                        $number_of_products_in_cart = count($array);
                    } else {
                        $number_of_products_in_cart = 0;
                    }
                    Cache::forever(Cookie::get('unique_id') . '.number_of_products_in_cart', $number_of_products_in_cart);
                }
            }

            $view->with('number_of_products_in_cart', $number_of_products_in_cart);
        });

        view()->composer('admin.layouts._left_menu', function ($view) {
            if (Cache::has('unopened_order_count')) {
                $unopened_order_count = Cache::get('unopened_order_count');
            } else {
                $unopened_order_count = Order::where('read_by_admin', '=', false)->count();
                Cache::forever('unopened_order_count', $unopened_order_count);
            }

            $view->with('unopened_order_count', $unopened_order_count);
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
