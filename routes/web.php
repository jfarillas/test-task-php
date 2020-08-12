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

$router->get(
    '/', function () use ($router) {
        return $router->app->version();
    }
);

$router->group(
    ['prefix' => 'api/v1'], function () use ($router) {
        // List of emails
        $router->get('audiences', ['as' => 'lists-retrieve', 'uses' => 'ListsController@showAudiences']);
        $router->post('audiences', ['as' => 'lists-create', 'uses' => 'ListsController@storeAudience']);
        $router->patch('audiences/{id}', ['as' => 'lists-update', 'uses' => 'ListsController@updateAudience']);
        $router->delete('audiences/{id}', ['as' => 'lists-delete', 'uses' => 'ListsController@deleteAudience']);

        // Members
        $router->get('lists/{id}/members', ['as' => 'members-retrieve', 'uses' => 'ListsController@showMembers']);
        $router->post('lists/{id}/members', ['as' => 'members-create', 'uses' => 'ListsController@storeMember']);
        $router->patch('lists/{id}/members', ['as' => 'members-update', 'uses' => 'ListsController@updateMember']);
        $router->delete('lists/{id}/members', ['as' => 'members-delete', 'uses' => 'ListsController@deleteMember']);
        
    }
);
