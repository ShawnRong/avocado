<?php

$router = app('router');

$router->namespace('ShawnRong\Avocado\Http\Controllers')
       ->prefix('auth')
       ->group(function ($router) {
           $router->post('login', 'AuthController@login');
           $router->post('logout', 'AuthController@logout');
           $router->post('refresh', 'AuthController@refresh');
           $router->post('me', 'AuthController@me');
       });
