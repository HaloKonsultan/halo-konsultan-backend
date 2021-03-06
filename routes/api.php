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

Route::prefix('users', ['middleware' => 'api'])->group(function () {
    Route::post('/register', 'UserController@register');
    Route::post('/login', 'UserController@login');
    Route::post('/logout', 'UserController@logout');
    Route::get('/profile/{id}', 'UserController@profile');
    Route::patch('/update/{id}', 'UserController@update');
    Route::post('/refresh', 'UserController@refresh');

    Route::prefix('consultants')->group(function () {
        Route::get('/{id}', 'UserController@consultant');
        Route::get('/search/{name}', 'UserController@searchConsultant');
        Route::get('/category/{id}', 'CategoriesController@consultant');
        Route::get('/city/{city}', 'CategoriesController@city');
    });

    Route::prefix('consultations',  ['middleware' => 'api'])->group(function () {
        Route::post('', 'UserConsultationController@booking');
        Route::get('/{id}', 'UserConsultationController@userConsultation');
        Route::post('/review/{id}', 'UserConsultationController@reviewConsultation');
        Route::patch('/review/{id}', 'UserConsultationController@updateReview');
        Route::patch('/{id}', 'ConsultationPreferenceDateController@sendDate');
        Route::post('/{id}/upload-document/{id_document}',
        'ConsultationDocumentController@uploadDoc');
        Route::get('/user/{id}/status/{status}',
        'UserConsultationController@userConsultationStatus');
        Route::get('/user/{id}/latest', 'UserConsultationController@getLatestConsultations');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/all', 'CategoriesController@all');
        Route::get('/random', 'CategoriesController@random');
    });

    Route::prefix('transaction')->group(function(){
        Route::post('/{id_consultation}/pay', 'TransactionController@createInvoice');
        Route::post('/invoice_callback','TransactionController@invoiceCallback');
        Route::get('/{id_transaction}', 'TransactionController@getTransanction');
    });

    Route::prefix('forums')->group(function () {
        Route::post('open-conversation', 'ForumController@conversation');
        Route::post('send/{id}', 'MessageController@userSend');
        Route::patch('read/{id}', 'MessageController@readByUser');
        Route::get('get-all-conversation/{id}', 'ForumController@getClientAllConversation');
        Route::get('get-all-messages/{id}', 'MessageController@getUserAllMessage');
    });

    Route::post('notification/{id}', 'NotificationController@sendUser');
});


Route::prefix('consultants',
['middleware' => 'consultants-api'])->group(function () {
    Route::post('/register', 'ConsultantController@register');
    Route::post('/login', 'ConsultantController@login');
    Route::post('/logout', 'ConsultantController@logout');
    Route::post('/refresh', 'ConsultantController@refresh');

    Route::prefix('profile')->group(function(){
        Route::get('/{id}', 'ConsultantController@profile');
        Route::patch('/biodata/{id}', 'ConsultantController@update');
        Route::post('upload/{id}', 'ConsultantController@uploadImage');
        Route::put('/consultation/{id}', 'ConsultantController@consultation');
        Route::delete('/virtual_account/{id}','ConsultantVirtualAccountController@destroy');
        Route::post('/documentation/{id}', 'ConsultantDocumentationController@upload');
        Route::delete('/documentation/{id}', 'ConsultantDocumentationController@destroy');
        Route::delete('/education/{id}', 'ConsultantEducationController@destroy');
        Route::delete('/skill/{id}', 'ConsultantSkillController@destroy');
        Route::delete('/experience/{id}', 'ConsultantExperienceController@destroy');
    });

    Route::get('{id}/history',
    'ConsultantConsultationController@getConsultationHistory');

    Route::prefix('consultations',
    ['middleware' => 'consultants-api'])->group(function () {
        Route::get('/{consultations_id}',
        'ConsultantConsultationController@consultantConsultation');
        Route::get('/user/{id}/status/{status}',
        'ConsultantConsultationController@getConsultationStatus');
        Route::get('/user/{id}/active',
        'ConsultantConsultationController@getActiveConsultation');
        Route::get('/user/{id}/incoming',
        'ConsultantConsultationController@getIncomingConsultation');
        Route::get('/user/{id}/today',
        'ConsultantConsultationController@getTodayConsultation');
        Route::get('/user/{id}/waiting',
        'ConsultantConsultationController@getWaitingConsultation');
        Route::get('/user/{id}/done',
        'ConsultantConsultationController@getCompletedConsultation');
        Route::get('/user/{id}/rejected',
        'ConsultantConsultationController@getRejectedConsultation');
        Route::patch('/{id}/send-link',
        'ConsultationController@sendLink');
        Route::patch('/{id}/accept',
        'ConsultationController@acceptConsultation');
        Route::patch('/{id}/decline',
        'ConsultationController@rejectConsultation');
        Route::patch('/{id}/after-book',
        'ConsultationController@updateConsultation');
        Route::patch('/{id}/end',
        'TransactionController@end');
    });

    Route::get('/categories', 'CategoriesController@consultantCategories');

    Route::prefix('transaction')->group(function(){
        Route::get('/{id_consultation}', 'TransactionController@getTransanction');
        Route::post('/withdraw/{id_consultation}', 'TransactionController@createDisbursement');
        Route::post('/withdraw_callback', 'TransactionController@disbursmentCallback');
    });

    Route::prefix('forums', ['middleware' => 'consultants-api'])->group(function () {
        Route::patch('end-conversation/{id}', 'ForumController@endConversation');
        Route::post('send/{id}', 'MessageController@consultantSend');
        Route::patch('read/{id}', 'MessageController@readByConsultant');
        Route::get('get-all-conversation/{id}', 'ForumController@getConsultantAllConversation');
        Route::get('get-all-messages/{id}', 'MessageController@getConsultantAllMessage');
    });

    Route::post('notification/{id}', 'NotificationController@sendConsultant');
});