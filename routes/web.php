<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('contact_us', function () {
    return view('contact_us');
})->name('contact_us');

Route::get('support_form', function() {
    return view('support_form');
})->name('support_form');

Route::get('settings', function() {
    return view('settings');
})->name('user.password.change')->middleware('auth');

Route::get('about_us', function() {
    return view('about_us');
})->name('about_us');

Route::get('profile', 'ProfileController@index')->name('user.settings')->middleware('auth');
Route::put('{user}/update', 'UsersController@update')->name('user.update')->middleware('auth');
Route::post('{user}/passwordupdate', 'UsersController@passwordreset')->name('user.password.update')->middleware('auth');

Route::post('subscribe', 'NewsletterController@store')->name('newsletter.subscribe');

Route::get('shop', 'CategoryController@index')->name("shop");


Route::get('shop/products', 'CategoryController@index')->name('shop.products');
Route::get('shop/products/{product}', 'ProductsController@show')->name("product.show");
Route::get('shop/{category}/products', 'CategoryController@show')->name("ProductCategory");
Route::get('products/highlighted', 'HomeController@highlighted_products')->name("highlighted_products");
Route::get('products/search', 'ProductsController@search')->name('products.search');

Route::post('/product/storeToCart/{product}', 'CartController@store')->name("cart.store");;
Route::post('/updateCart', 'CartController@update')->name("cart.update");
Route::delete('/products/deleteFromCart', 'CartController@destroy')->name("cart.delete");;

Route::get('cart', 'CartController@index')->name("cart.show");
Route::get('order', 'OrderController@store')->name("order.store")->middleware('auth');
Route::get('orders', 'OrderController@index')->name("user.orders.show")->middleware('auth');
Route::get('order/{order}', 'OrderController@show')->name("user.order.show")->middleware('auth');


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin'] ], function () {
    # Dashboard / Index
    Route::get('/', ['as' => 'dashboard','uses' => 'AdminCPController@index']);

    # User Management
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', ['as' => 'users', 'uses' => 'UsersController@index'])->name('admin.dashboard');
        Route::get('data',['as' => 'users.data', 'uses' =>'UsersController@data']);
        Route::get('index', ["as" => "users.index", "uses" => "UsersController@index"]);
        Route::get('create', ["as" => "users.create", "uses" => "UsersController@create"]);
        Route::post('create', 'UsersController@store');
        Route::get('{user}/edit', ["as" => "users.edit", "uses" => "UsersController@edit"]);
        Route::patch('{user}/update', ["as" => "users.update", "uses" => "UsersController@update"]);
        Route::get('{user}/delete', ['as' => 'delete/user', 'uses' => 'UsersController@destroy']);
        Route::get('{user}/confirm-delete', ['as' => 'confirm-delete/user', 'uses' => 'UsersController@getModalDelete']);
        Route::get('{user}/restore', ['as' => 'restore/user', 'uses' => 'UsersController@getRestore']);
        Route::get('{user}', ['as' => 'users.show', 'uses' => 'UsersController@show']);
        Route::get('/{user}/orders', ['as' => 'users.order.data', 'uses' => 'UsersController@showOrders']);
        Route::post('{user}/passwordreset', ['as' => 'passwordreset', 'uses' => 'UsersController@passwordreset']);
    });

    # Product Management
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', ['as' => 'products.index', 'uses' => 'ProductsController@index']);
        Route::get('data', ['as' => 'products.data', 'uses' =>'UsersController@data']);
        Route::get('create', ['as' => 'products.create', 'uses' => 'ProductsController@create']);
        Route::post('/', ['as' => 'products.store', 'uses' => 'ProductsController@store']);
        Route::get('{product}/edit', ['as' => 'products.edit', 'uses' => 'ProductsController@edit']);
        Route::patch('{product}', ['as' => 'products.update', 'uses' => 'ProductsController@update']);
        Route::get('{product}/delete', ['as' => 'products.destroy', 'uses' => 'ProductsController@destroy']);
        Route::get('{product}/confirm-delete', ['as' => 'products.confirm-delete', 'uses' => 'ProductsController@getModalDelete']);
    });

    # Categories Management
    Route::group(['prefix' => 'categories'], function () {
        Route::get('create', ['as' => 'categories.create', 'uses' => 'CategoryController@create']);
        Route::post('create', ['as' => 'categories.create', 'uses' => 'CategoryController@store']);
        Route::get('delete', ['as' => 'categories.showCategoriesDeleteView', 'uses' => 'CategoryController@getDeleteView']);
        Route::post('/', ['as' => 'categories.delete', 'uses' => 'CategoryController@delete']);
    });

    Route::get('all_orders', ['as' => 'orders.show', 'uses' => 'OrderController@getAllOrders']);
    Route::get('order/{order}', ['as' => 'user.order.show', 'uses' => 'OrderController@order_details']);
    Route::patch('order/{order}', ['as' => 'user.order.update', 'uses' => 'OrderController@update']);

    Route::get('all_products', ['as' => 'products.show', 'uses' => 'ProductsController@getAllProducts']);

    //Route::get('{name?}', 'AdminCPController@showView');

});
