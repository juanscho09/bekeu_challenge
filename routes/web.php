<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')
        ->name('home');

    // Importar estados
    Route::get('/states', 'StateController@index')
        ->name('states');
    Route::post("/states/store", 'StateController@store')
        ->name('states.store');
    
    // Suscripciones
    Route::resource('subscriptions', 'SubscriptionController');
    // Subscription - ajax
    Route::get('subscriptions_ajax', 'SubscriptionController@index_ajax')
        ->name('subscriptions.index_ajax');
    Route::post('/subscriptions/remove/{subcription}', 'SubscriptionController@remove')
        ->name('subscriptions.remove');
});

