<?php

//Dingo API Routes
$api = app('Dingo\Api\Routing\Router');

//TODO: add routes in ServiceProvider
//api version
$api->version('v1', function($api) {
    // AuthController
    $api->group([
        'namespace' => 'ShawnRong\Avocado\Controllers',
    ], function($api) {
        $api->post('login', 'AuthController@login');
    });

    // Require login request
    $api->group([
        'middleware' => 'auth:api',
        'namespace' => 'ShawnRong\Avocado\Controllers',
    ], function($api) {
        $api->post('logout', 'AuthController@logout');
        $api->post('refresh', 'AuthController@refresh');
        $api->post('me', 'AuthController@me');
        // Update current user info
        $api->patch('user', 'AuthController@patch');

        // AdminUserController
        // User Lista
        $api->get('users', 'AdminUserController@index');
        // User Detail
        $api->get('user/{id}', 'AdminUserController@show');
        // User Update name
        $api->patch('user/{id}', 'AdminUserController@patch'); 
        // User Update password
        $api->put('user/password', 'AdminUserController@editPassword');
        // Add User
        $api->post('user/add', 'AdminUserController@store');
        // Delete User
        $api->delete('user/{id}', 'AdminUserController@destroy');
        $api->get('user/{id}/roles', 'AdminUserController@roles');
        $api->put('user/{id}/roles', 'AdminUserController@assignRoles');
        $api->resource('roles', 'AdminRoleController');
        $api->get('role/{id}/permissions', 'AdminRoleController@permissions');
        $api->put('role/{id}/permissions', 'AdminRoleController@assignPermissions');
        $api->get('guard-name-roles/{guardName}', 'AdminRoleController@guardNameRoles');
        $api->get('permission-all', 'AdminPermissionController@allPermissions');
        $api->resource('permissions', 'AdminPermissionController');
        $api->resource('permission-groups', 'AdminPermissionGroupController');
    });
});

$router = app('router');
$router->namespace('ShawnRong\Avocado\Controllers')->middleware('web')->group(function ($router) {
    $router->get('avocado', function () {
        return view('dashboard');
    });
});
