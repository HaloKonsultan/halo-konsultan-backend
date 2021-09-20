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

Route::post('/user/register', 'UserController@register');
Route::post('/user/login', 'UserController@login');


Route::prefix('user', ['middleware' => 'api'])->group(function () {
    Route::get('/show', 'UserController@show');
    Route::post('/logout', 'UserController@logout');
});

Route::post('/consultant/register', 'ConsultantController@register');
Route::post('/consultant/login', 'ConsultantController@login');

Route::prefix('consultant', ['middleware' => 'consultants-api'])->group(function () {
    Route::post('/logout', 'ConsultantController@logout');
    Route::get('/show', 'ConsultantController@show');
});
