<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('user', ['middleware' => 'api'])->group(function () {
    Route::post('/register', 'UserController@register');
    Route::post('/login', 'UserController@login');
    Route::get('/profile/{id}', 'UserController@profile');
    Route::prefix('consultant')->group(function () {
        Route::get('/{id}', 'UserController@consultant');
        Route::get('/search/{name}', 'UserController@searchConsultant');
        Route::get('/category/{id}', 'CategoriesController@consultant');
    });
    Route::prefix('consultation')->group(function () {
        Route::get('/{id}', 'UserController@consultation');
        Route::get('/user/{id}/status/{status}', 'UserController@status');
    });
    Route::prefix('category', ['middleware' => 'api'])->group(function () {
        Route::get('/all', 'CategoriesController@all');
        Route::get('/random', 'CategoriesController@random');
        Route::get('/consultants/{city}', 'CategoriesController@city');
    });
    
});


Route::prefix('consultant', ['middleware' => 'consultants-api'])->group(function () {
    Route::post('/register', 'ConsultantController@register');
    Route::post('/login', 'ConsultantController@login');
    Route::get('/profile/{id}', 'ConsultantController@profile');
    Route::get('/show', 'ConsultantController@show');
    Route::get('/history/{id}','ConsultantController@history');
    Route::prefix('consultation')->group(function () {
        Route::get('/{id}', 'ConsultantController@consultation');
        Route::get('/user/{id}/status/{status}', 'ConsultantController@status');
        Route::get('/user/{id}/active', 'ConsultantController@active');
        Route::get('/user/{id}/incoming', 'ConsultantController@incoming');
        Route::get('/user/{id}/today', 'ConsultantController@today');
        Route::get('/user/{id}/waiting', 'ConsultantController@waiting');
    });
});

