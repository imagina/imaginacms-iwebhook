<?php

use Illuminate\Routing\Router;

$router->group(['prefix' =>'/iwebhooks/v1'], function (Router $router) {
    $router->apiCrud([
      'module' => 'iwebhooks',
      'prefix' => 'categories',
      'controller' => 'CategoryApiController',
      //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []],
      // 'customRoutes' => [ // Include custom routes if needed
      //  [
      //    'method' => 'post', // get,post,put....
      //    'path' => '/some-path', // Route Path
      //    'uses' => 'ControllerMethodName', //Name of the controller method to use
      //    'middleware' => [] // if not set up middleware, auth:api will be the default
      //  ]
      // ]
    ]);
    $router->apiCrud([
      'module' => 'iwebhooks',
      'prefix' => 'hooks',
      'controller' => 'HookApiController',
      //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []],
      'customRoutes' => [
        [
          'method' => 'post', // get,post,put....
          'path' => '/dispatch/{criteria}', // Route Path
          'uses' => 'dispatch', //Name of the controller method to use
          //'middleware' => [] // if not set up middleware, auth:api will be the default
        ]
      ]
    ]);
    $router->apiCrud([
      'module' => 'iwebhooks',
      'prefix' => 'logs',
      'controller' => 'LogApiController',
      //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []],
      // 'customRoutes' => [ // Include custom routes if needed
      //  [
      //    'method' => 'post', // get,post,put....
      //    'path' => '/some-path', // Route Path
      //    'uses' => 'ControllerMethodName', //Name of the controller method to use
      //    'middleware' => [] // if not set up middleware, auth:api will be the default
      //  ]
      // ]
    ]);
// append



});
