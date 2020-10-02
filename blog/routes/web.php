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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function($router){
    $router->get('nurseries', 'NurseryController@showNurseryByDistance');
    $router->get('nurseries/{n_id}','CategoryController@showCategories');
    $router->get('nurseries/categories/{c_id}/plants','PlantController@showPlants');
    $router->get('nurseries/categories/plants/{p_id}','PlantController@showPlantDetails');
    $router->post('admin/create','AdminController@createAdmin');
    $router->post('admin/login','AdminController@loginAdmin');
});
