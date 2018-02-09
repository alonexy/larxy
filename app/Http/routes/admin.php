<?php
/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/2/1
 * Time: 15:27
 */
Route::group([ 'prefix' => 'admin','middleware' => ['auth','auth.basic','check.admin'], 'as' => 'admin::','namespace' => 'Admin'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('/home/create', ['as' => 'home', 'uses' => 'HomeController@create']);
    Route::get('/roles', ['as' => 'roles', 'uses' => 'RolesController@index']);
    Route::any('/role/create', ['as' => 'role::create', 'uses' => 'RolesController@create']);
    Route::any('/role/edit', ['as' => 'role::edit', 'uses' => 'RolesController@edit']);
    Route::post('/role/destroy', ['as' => 'role::destroy', 'uses' => 'RolesController@destroy']);

    Route::get('/users', ['as' => 'users', 'uses' => 'UsersController@index']);
    Route::any('/user/create', ['as' => 'user::create', 'uses' => 'UsersController@create']);
    Route::any('/user/edit', ['as' => 'user::edit', 'uses' => 'UsersController@edit']);
    Route::post('/user/destroy', ['as' => 'user::destroy', 'uses' => 'UsersController@destroy']);

    Route::get('/articles', ['as' => 'articles', 'uses' => 'ArticlesController@index']);
});
Route::group(['namespace' => 'Auth', 'as' => 'auth::'], function () {
    // 登录认证路由
    Route::get('auth/login', ['as'=>'login::get','uses'=>'AuthController@getLogin']);
    Route::post('auth/login', ['as'=>'login::post','uses'=>'AuthController@postLogin']);
    Route::get('auth/logout', ['as'=>'logout','uses'=>'AuthController@getLogout']);
//    // 注册用户路由
//    Route::get('auth/register', ['as'=>'register::get','middleware' => ['auth'],'uses'=>'AuthController@getRegister']);
//    Route::post('auth/register', ['as'=>'register::post','middleware' => ['auth'],'uses'=>'AuthController@postRegister']);
    Route::get('auth/weixin', 'AuthController@weixin');
    Route::any('auth/callback', 'AuthController@weixin_callback');
});