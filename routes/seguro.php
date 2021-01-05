<?php

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

Route::group(['prefix' => 'seguro-auto'], function () {
    Route::get('/', function () {
        return redirect('/seguro-auto/info');
    });
    Route::group(['prefix' => 'info'], function () {
        Route::get('/', 'SeguroAuto\InsuranceInfoController@index');
        Route::get('/postback', 'SeguroAuto\InsuranceInfoController@postback');
        Route::post('/', 'SeguroAuto\InsuranceInfoController@store');
    });

    Route::group(['prefix' => 'step-one'], function () {
        Route::get('/','SeguroAuto\StepOneController@index');
        Route::get('/redirect', 'SeguroAuto\StepOneController@redirect');
    });

    Route::group(['prefix' => 'step-two'], function () {
        Route::get('/','SeguroAuto\StepTwoController@index');
        Route::get('/redirect', 'SeguroAuto\StepTwoController@redirect');
        Route::post('/', 'SeguroAuto\StepTwoController@store');
    });    

    Route::group(['prefix' => 'step-three'], function () {
        Route::get('/','SeguroAuto\StepThreeController@index');
        Route::get('/redirect', 'SeguroAuto\StepThreeController@redirect');
        Route::post('/', 'SeguroAuto\StepThreeController@store');
    });      

    Route::group(['prefix' => 'research'], function () {
        Route::get('/', 'SeguroAuto\ResearchesController@index');
        Route::post('/', 'SeguroAuto\ResearchesController@store');
    });

    Route::get('final', 'SeguroAuto\FinalController@index');

});