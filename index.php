<?php

use lithium\action\Dispatcher;
use lithium\action\Request;
use lithium\core\Libraries;

/**
 * This is the path to the class libraries used by your application, and must contain a copy of the
 * Lithium core.  By default, this directory is named `libraries`, and resides in the same
 * directory as your application.  If you use the same libraries in multiple applications, you can
 * set this to a shared path on your server.
 */
define('LITHIUM_LIBRARY_PATH', dirname(__DIR__) . '/libraries');

/**
 * Locate and load Lithium core library files.  Throws a fatal error if the core can't be found.
 * If your Lithium core directory is named something other than 'lithium', change the string below.
 */
if (!include LITHIUM_LIBRARY_PATH . '/lithium/core/Libraries.php') {
	$message  = "Lithium core could not be found.  Check the value of LITHIUM_LIBRARY_PATH in ";
	$message .= __FILE__ . ".  It should point to the directory containing your ";
	$message .= "/libraries directory.";
	throw new ErrorException($message);
}

/**
 * Add Lithium
 */
Libraries::add('lithium');

/**
 * Include routes
 */
include 'routes.php';

/**
 * Include filters
 */
include 'filters.php';
 
/**
 * Run It!
 */
echo Dispatcher::run(new Request());
