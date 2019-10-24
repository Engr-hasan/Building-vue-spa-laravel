<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|$users =
        array (
            array("name"=>"hasan",
            "email"=>"hasan@gmail.com"),
            array("name"=>"mithun",
                "email"=>"mithun@gmail.com"),
            array("name"=>"rohim",
                "email"=>"rohim@gmail.com"),
            array("name"=>"korim",
                "email"=>"korim@gmail.com"),
            array("name"=>"jahid",
                "email"=>"jahid@gmail.com")
        );
    return $users;

| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', function () {
    return factory('App\User', 10)->make();
});

