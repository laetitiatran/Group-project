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
    return app()->version();
});

$router->get('/user/test', function () {
    return 'Hello World';
});

$router->post('/user/login', ['as' => 'login', 'uses' => 'userController@userLogin']);
$router->post('/user/register', ['as' => 'register', 'uses' => 'userController@userRegister']);

$router->group(['prefix' => 'user', 'middleware' => 'auth'], function () use ($router) {
    // Routing User operations
    $router->post('update', ['as' => 'update', 'uses' => 'userController@userUpdate']);
    $router->get('logout', ['as' => 'logout', 'uses' => 'userController@userLogout']);

    // Routing Tasks operations
    $router->post('createTask', ['as' => 'createTask', 'uses' => 'taskController@taskCreate']);
    $router->post('findTask', ['as' => 'findTask', 'uses' => 'taskController@findOneTask']);
    
});



/**
 * Routes for resource message-controller
 */
$app->get('message-controller', 'MessageController@all');
$app->get('message-controller/{id}', 'MessageController@get');
$app->post('message-controller', 'MessageController@add');
$app->put('message-controller/{id}', 'MessageController@put');
$app->delete('message-controller/{id}', 'MessageController@remove');
