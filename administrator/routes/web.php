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

$router->group(['prefix'=>'api/admin'], function() use($router)
{
    $router->post('/createNurseries','NurseryController@createNurseries');
    $router->put('/editNurseries','NurseryController@editNurseries');
    $router->get('/getCategories/{Nursery_ID}','CategoryController@showCategories');
    $router->get('/getCategoryDetails/{Category_ID}','CategoryController@showCategoryDetails');
    $router->post('/createCategories','CategoryController@createCategories');
    $router->post('/uploadCategoryImage','CategoryController@uploadCategoryImage');
    $router->post('/editCategories','CategoryController@editCategories');
    $router->delete('/deleteCategories','CategoryController@deleteCategories');
    $router->get('/getPlants/{Category_ID}','PlantController@getPlants');
    $router->get('/getPlantDetails/{Plant_ID}','PlantController@getPlantDetails');
    $router->post('/createPlants','PlantController@createPlants');
    $router->post('/editPlants','PlantController@editPlants');
    $router->post('/uploadPlantImage','PlantController@uploadPlantImage');
    $router->delete('/deletePlants','PlantController@deletePlants');
});
