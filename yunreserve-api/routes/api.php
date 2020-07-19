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

Route::namespace("Api")->prefix('channel')->group(function(){
    Route::get('/status/{channelId?}', 'machineController@getChannalStatus');
    Route::get('/product/{channelId}', 'machineController@getProduct');
    Route::get('/getSignupQRcode', 'machineController@getSignupQRcode');
    Route::get('/getChangeMemberInfoQRcode', 'machineController@getChangeMemberInfoQRcode');
    Route::get('/getForgetMemberQRcode', 'machineController@getForgetMemberQRcode');
    Route::get('/getContractQRcode', 'machineController@getContractQRcode');
    Route::post('/launch', 'machineController@launch');
    Route::post('/login', 'machineController@login');
    Route::post('/recall', 'machineController@recall');
    Route::post('/productOwner', 'machineController@productOwner');
    Route::post('/checkPayment/TWpay',"machineController@check_TWpay");
    // Route::get('/create','machineController@createChannels');
});


Route::namespace("Api")->prefix('website')->group(function(){
    Route::post('/signup',"websiteController@signup");
    Route::post('/changeAccount',"websiteController@changeAccount");
    Route::get('/verifyAccount/{account}/{verifyCode}',"websiteController@verifyAccount");
    Route::post('/forgetAccount',"websiteController@forgetAccount");
});