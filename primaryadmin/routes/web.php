<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix'=>'api/primaryadmin'], function() use($router)
{
    $router->get('/getNurseries','NurseryController@getNurseries');
    $router->get('/getNurseries/{ID}','NurseryController@getNursery');
    $router->post('/createNurseries','NurseryController@createNurseries');
    $router->post('/editNurseries','NurseryController@editNurseries');
    $router->post('/uploadNurseryBanner','NurseryController@uploadNurseryBanner');
    $router->get('/getAdmins','AdminController@getAdmins');
    $router->get('/getAdmins/{ID}','AdminController@getAdmin');
    $router->post('/createAdmin','AdminController@createAdmin');
    $router->get('/getCategories/{Nursery_ID}','CategoryController@showCategories');
    $router->get('/getCategoryDetails/{Category_ID}','CategoryController@showCategoryDetails');
    $router->post('/createCategories','CategoryController@createCategories');
    $router->post('/uploadCategoryImage','CategoryController@uploadCategoryImage');
    $router->post('/editCategories','CategoryController@editCategories');
    $router->delete('/deleteCategories','CategoryController@deleteCategories');
});