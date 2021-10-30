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

Route::prefix('users', ['middleware' => 'api'])->group(function () {
    Route::post('/register', 'UserController@register');
    Route::post('/login', 'UserController@login');
    Route::post('/logout', 'UserController@logout');
    Route::get('/profile/{id}', 'UserController@profile');
    Route::get('/update/{id}', 'UserController@update');
    Route::prefix('consultants')->group(function () {
        Route::get('/{id}', 'UserController@consultant');
        Route::get('/search/{name}', 'UserController@searchConsultant');
        Route::get('/category/{id}', 'CategoriesController@consultant');
        Route::get('/city/{city}', 'CategoriesController@city');
    });
    Route::prefix('consultations',  ['middleware' => 'api'])->group(function () {
        Route::post('', 'ConsultationController@booking');
        Route::get('/{id}', 'ConsultationController@userConsultation');
        Route::patch('/{id}', 'ConsultationPreferenceDateController@sendDate');
        Route::post('/{id}/upload-document/{id_document}',
        'ConsultationDocumentController@uploadDoc');
        // Route::post('/{id}/change-document/{id_document}',
        // 'ConsultationDocumentController@updateDoc');
        Route::get('/user/{id}/status/{status}',
        'ConsultationController@userConsultationStatus');
        Route::patch('/transaction/{id}', 'TransactionController@update');
    });
    Route::prefix('categories', ['middleware' => 'api'])->group(function () {
        Route::get('/all', 'CategoriesController@all');
        Route::get('/random', 'CategoriesController@random');
    });
});


Route::prefix('consultants',
['middleware' => 'consultants-api'])->group(function () {
    Route::post('/register', 'ConsultantController@register');
    Route::post('/login', 'ConsultantController@login');
    Route::post('/logout', 'ConsultantController@logout');
    Route::prefix('profile')->group(function(){
        Route::get('/{id}', 'ConsultantController@profile');
        Route::patch('/biodata/{id}', 'ConsultantController@update');
        Route::patch('/consultation/{id}', 'ConsultantController@consultation');
    });
    Route::get('{id}/history','ConsultationController@getConsultationHistory');
    Route::prefix('consultations',
    ['middleware' => 'consultants-api'])->group(function () {
        Route::get('/{consultations_id}', 'ConsultationController@consultantConsultation');
        Route::get('/user/{id}/status/{status}',
        'ConsultationController@getConsultationStatus');
        Route::get('/user/{id}/active',
        'ConsultationController@getActiveConsultation');
        Route::get('/user/{id}/incoming',
        'ConsultationController@getIncomingConsultation');
        Route::get('/user/{id}/today',
        'ConsultationController@getTodayConsultation');
        Route::get('/user/{id}/waiting',
        'ConsultationController@getWaitingConsultation');
        Route::get('/user/{id}/done',
        'ConsultationController@getCompletedConsultation');
        Route::get('/user/{id}/rejected',
        'ConsultationController@getRejectedConsultation');
        Route::patch('/{id}/send-link',
        'ConsultationController@sendLink');
        Route::patch('/{id}/accept',
        'ConsultationController@acceptConsultation');
        Route::patch('/{id}/decline',
        'ConsultationController@rejectConsultation');
        Route::patch('/{id}/after-book',
        'ConsultationController@updateConsultation');
        Route::patch('/{id}/end',
        'TransactionConsultation@end');
    });
});

