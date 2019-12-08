<?php

use Illuminate\Http\Request;

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

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
Route::post('select_photo_to_match', 'Api\MainController@select_photo_to_match');
Route::post('select_colorful_photo_to_match', 'Api\MainController@select_colorful_photo_to_match');
Route::post('select_facepartition_photo_to_match', 'Api\MainController@select_facepartition_photo_to_match');


Route::post('add_color', 'Api\MainController@add_color');

Route::post('add_facePartition', 'Api\MainController@add_facePartition');

Route::post('colorful_attemps', 'Api\AttemptController@colorful_attemps');
Route::post('matching_attemps', 'Api\AttemptController@matching_attemps');
Route::post('partition_attemps', 'Api\AttemptController@partition_attemps');






Route::group(['middleware' => ['auth:parents']], function () {
    Route::post('capture_img', 'Api\MainController@add_photo');
    Route::post('add_template_photo', 'Api\MainController@add_template_photo');
    Route::post('add_colorfulphoto', 'Api\MainController@add_colorfulphoto');
    Route::post('add_partitionsphoto', 'Api\MainController@add_partitionsphoto');
    Route::post('add_code_to_user', 'Api\MainController@add_code_to_user');


    Route::post('partition_reports', 'Api\ReportsController@partition_reports');
    Route::post('colourful_reports', 'Api\ReportsController@colourful_reports');
    Route::post('match_reports', 'Api\ReportsController@match_reports');

    
    
    

});
