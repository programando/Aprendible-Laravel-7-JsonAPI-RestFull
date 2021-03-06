<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use CloudCreativity\LaravelJsonApi\Facades\JsonApi;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
 */

/*  Route::get('articles/{article}', 'Api\ArticleController@show')->name('api.articles.read');
 Route::get('articles', 'Api\ArticleController@index')->name('api.articles.index'); */

 JsonApi::register('balquimia')->routes( function ($api) {
     $api->resource('articles');
 });