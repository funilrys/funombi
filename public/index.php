<?php

/*
 * The MIT License
 *
 * Copyright 2017 Nissar Chababy <contact at funilrys dot com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Composer
 */
$root       = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$autoloader = $root . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

if (is_file($autoloader)) {
    require $autoloader;
} else {
    echo 'Please install the dependencies with <b>"bin/composer.phar update"</b> from <i>the project root directory</i>.<br /><br /> If this message persist, please check the permissions of your current project.';
    exit();
}

/**
 * The following is for safety reason. Indeed, to debug we will exclusively use
 * Kint as it helps a lot.
 * 
 * The following disable the loading of Kint when we are in production mode.
 */
if (App\Config\Errors::SHOW_ERRORS) {
    \Kint::$enabled_mode = true;
} else {
    \Kint::$enabled_mode = false;
}

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);

$router->add('403', ['controller' => 'Errors', 'action' => 'forbidden']);
$router->add('404', ['controller' => 'Errors', 'action' => 'notFound']);
$router->add('500', ['controller' => 'Errors', 'action' => 'internalServerError']);
$router->add('502', ['controller' => 'Errors', 'action' => 'badGateway']);
$router->add('503', ['controller' => 'Errors', 'action' => 'serviceUnavailable']);
$router->add('504', ['controller' => 'Errors', 'action' => 'gatewayTimeout']);

$router->dispatch($_SERVER['QUERY_STRING']);
