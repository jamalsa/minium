<?php
use lithium\action\Response;
use lithium\net\http\Router;

// GET request
Router::connect('/', array('http:method' => "GET"), function($request) {
	return new Response(array('body' => 'Hello world'));
});

// POST request
Router::connect('/post', array('http:method' => "POST"), function($request) {
	return new Response(array('body' => $this->request->data));
});

// PUT request
Router::connect("/put", array("http:method" => "PUT"),
    function($request){
        return new Response(array('body' => $this->request->data));
    }
);

// DELETE request
Router::connect("/delete", array("http:method" => "DELETE"),
    function($request){
        return new Response(array('body' => 'Data has been deleted'));
    }
);

// Allow POST or PUT::
Router::connect("/update", array("http:method" => array("POST", "PUT")),
    function($request){
        return new Response(array('body' => $this->request->data));
    }
);

// Named parameter
Router::connect("/hello/{:name}", array("http:method" => "GET", "name" => null),
    function($request) {
        $name = $request->name ?: 'World';
        return new Response(array('body' => "Hello {$name}!"));
    }
);

// Pattern
Router::connect('/user/{:id:[0-9]+}', array("http:method" => "GET"),
    function($request) {
        $id = $request->id ?: 0;
        return new Response(array('body' => "Id: {$id}"));
    }
);

// Conditional Routing
// Only match if on the localhost server and GET request:
Router::connect("/secret", array("http:method" => "GET", "http:host" => "localhost"),
    function($request){
        return new Response(array('body' => "You are in localhost"));
    }
);

// Only match if request is over HTTPS and GET request:
Router::connect("/admin", array("http:method" => "GET", "env:https" => true),
    function($request){
        return new Response(array('body' => "You are using https"));
    }
);

// Passing
// If $name is not jamal, pass it to next route
Router::connect("/guess/{:name}", array("http:method" => "GET"),
    function($request){
        $name = $request->name;
        if($name == 'jamal') {
            return new Response(array('body' => "You can guess my name.!"));
        }
        return false;
    }
);

// Match every access to /guess/*
Router::connect("/guess/{:name}", array("http:method" => "GET"),
    function($request){
        return new Response(array('body' => "Try again!"));
    }
);