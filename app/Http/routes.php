<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->group([
    'prefix' => config('app.admin_url'),
    'namespace' => 'Admin\Http\Controllers'
    ], function () use ($app) {

    $app->get('/', array('uses' => 'MainController@index'));
    $app->post('/', array('uses' => 'MainController@index'));
});

$app->group([
    'prefix' => config('app.admin_url'),
    'namespace' => 'Admin\Http\Controllers',
    'middleware' => 'auth.admin'
    ], function () use ($app) {

        $app->get('/site/tree', array('uses' => 'SiteController@tree'));
        $app->get('/site/template/{id}', array('uses' => 'SiteController@template'));
        $app->get('/site/settings/{id}', array('uses' => 'SiteController@settings'));
        $app->get('/site/reimage/{id}', array('uses' => 'SiteController@reimage'));
        $app->get('/site/create/{id}', array('uses' => 'SiteController@create'));        
        $app->get('/site/act/{id}', array('uses' => 'SiteController@act'));
        $app->get('/site/restore/{id}', array('uses' => 'SiteController@restore'));
        $app->delete('/site/delete/{id}', array('uses' => 'SiteController@delete'));
        routeResource($app, '/site', 'SiteController');

        $app->get('/block/create/{id}', array('uses' => 'BlockController@create'));
        $app->get('/block/tree', array('uses' => 'BlockController@tree'));
        $app->get('/block/act/{id}', array('uses' => 'BlockController@act'));
        routeResource($app, '/block', 'BlockController');

        $app->get('/menu/create/{id}', array('uses' => 'MenuController@create'));
        $app->get('/menu/tree', array('uses' => 'MenuController@tree'));
        $app->get('/menu/act/{id}', array('uses' => 'MenuController@act'));
        routeResource($app, '/menu', 'MenuController');        

        $app->post('/image/group', array('uses' => 'ImageController@group'));
        $app->get('/image/act/{id}', array('uses' => 'ImageController@act'));
        $app->get('/image/content/{id}/{view}', array('uses' => 'ImageController@content'));
        $app->get('/image/upload', array('uses' => 'ImageController@upload'));
        $app->get('/image/items/delete', array('uses' => 'ImageController@itemsDelete'));
        $app->get('/image/items/{view}', array('uses' => 'ImageController@items'));
        routeResource($app, '/image', 'ImageController');

        $app->get('/video/data', array('uses' => 'VideoController@data'));
        $app->get('/video/group', array('uses' => 'VideoController@group'));
        $app->get('/video/act/{id}', array('uses' => 'VideoController@act'));
        $app->get('/video/items/delete', array('uses' => 'VideoController@itemsDelete'));
        $app->get('/video/upload', array('uses' => 'VideoController@upload'));
        $app->get('/video/preview', array('uses' => 'VideoController@preview'));
        routeResource($app, '/video', 'VideoController');

        $app->get('/file/data', array('uses' => 'FileController@data'));
        $app->get('/file/group', array('uses' => 'FileController@group'));
        $app->get('/file/act/{id}', array('uses' => 'FileController@act'));
        $app->get('/file/upload', array('uses' => 'FileController@upload'));
        routeResource($app, '/file', 'FileController');        

        routeResource($app, '/role', 'RoleController');
        routeResource($app, '/user', 'UserController');
        $app->get('/user/act/{id}', array('uses' => 'UserController@act'));        

        $app->get('/logout', array('uses' => 'MainController@logout'));
});
