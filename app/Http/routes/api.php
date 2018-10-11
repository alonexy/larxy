<?php

Route::group(['namespace' => 'Api', 'as' => 'api::','prefix' => 'api/v1','middleware' => ['cors']], function () {

    Route::any('test', ['as'=>'ExternalController::test','uses'=>'ExternalController@test']);
});