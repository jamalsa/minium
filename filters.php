<?php

use lithium\action\Dispatcher;
use lithium\net\http\Router;
use lithium\action\Response;
use lithium\security\Auth;

// Filter all request
Dispatcher::applyFilter('run', function($self, $params, $chain) {
    // Do something before
    $result = $chain->next($self, $params, $chain);
    // Do something after
    return $result;
});

// Filter GET request
Dispatcher::applyFilter('run', function($self, $params, $chain) {
    if($params['request']->method == 'GET') {
        // Do something before
    }
    $result = $chain->next($self, $params, $chain);
    if($params['request']->method == 'GET') {
        // Do something after
    }
    return $result;
});

// Protect some routes from unauthorized user

Dispatcher::applyFilter('run', function($self, $params, $chain) {
    // First, define our list of protected actions
    $blacklist = array(
        '/users/report',
        '/users/home'
    );

    // Inspect the request to get the URL for the route the request matches
    $matches = in_array(Router::match($params['request']->params, $params['request']), $blacklist);

    // If this is a match, check it against an Auth configuration.
    if($matches && !Auth::check('default', $params['request'])) {
        // If the Auth check can't verify the user, redirect.
        return new Response(array('location' => '/users/login'));
    }

    // Important: return the results of the next filter in the chain.
    return $chain->next($self, $params, $chain);
});