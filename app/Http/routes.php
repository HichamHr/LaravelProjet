<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*Route::group(['prefix'=>''] ,function(){});*/

Route::group(['prefix' => 'api'], function () {
    Route::post('login', 'API\Auth@Login');
    Route::post('register', 'API\Auth@Register');

    Route::get('profile', ['uses' => 'API\Auth@ProfileAccount']);

    Route::controller('profile','API\Models\Profile');
    Route::controller('specialite', 'API\Models\Specialite');
    Route::controller('exam', 'API\Models\Exams');
    Route::controller('module', 'API\Models\Modules');
    Route::controller('passage', 'API\Models\Passage');
    Route::controller('pile', 'API\Models\Piles');
    Route::controller('question', 'API\Models\Questions');
    Route::controller('reponse', 'API\Models\Reponses');

});



