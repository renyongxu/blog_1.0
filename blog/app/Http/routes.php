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

Route::group(['middlware' => ['web']],function (){
    Route::get('/','Home\IndexController@index');
    Route::get('cate/{cate_id}','Home\IndexController@cate');
    Route::get('a/{art_id}','Home\IndexController@art');

});

Route::group(['middleware' => ['web'],'prefix'=>'admin','namespace'=>'Admin'], function () {


    Route::any('login', 'LoginController@login');
    Route::any('code', 'LoginController@code');



});
Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function (){

    //  首页信息路由
    Route::get('/','IndexController@index');
    Route::get('info','IndexController@info');
    Route::get('quit','IndexController@quit');
    Route::any('pass','IndexController@pass');

    //  资源路由,文章分类
    Route::resource('category','CategoryController');
    Route::post('cate/changeorder','CategoryController@changeOrder');

    // 文章
    Route::resource('article','ArticleController');
    //友情链接
    Route::resource('links','LinksController');
    Route::post('links/changeorder','LinksController@changeOrder');

    // 导航栏
    Route::resource('navs','NavsController');
    Route::post('navs/changeorder','NavsController@changeOrder');

    //  网站配置
    Route::resource('config','ConfigController');
    Route::post('config/changeorder','ConfigController@changeOrder');

    // 上传文件
    Route::any('upload','CommonController@upload');


    Route:: get('test','TestController@info');


});
