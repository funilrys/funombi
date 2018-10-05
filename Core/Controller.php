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
 * Class Controller | Core/Controller.php
 *
 * @package     funombi\Core
 * @author      Nissar Chababy <contact at funilrys dot com>
 * @version     1.0.0
 * @copyright   Copyright (c) 2017, Nissar Chababy
 */

namespace Core;

use App\Config\Sessions as SessionConfig;

/**
 * Main logic behind Controller call and usage.
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Controller
{

    /**
     * Parameters from the matched route.
     * @var array
     */
    protected $route_params = [];

    /**
     * Base of the server.
     * @var string
     */
    protected $siteBase = "";

    /**
     * URL we are redirecting once we are done witht the communication with the
     * Model.
     * @var string
     */
    protected $referer = "";

    /**
     * Class constructor.w
     * 
     * @param array $route_params Parameters from the route
     * @return void
     */
    public function __construct(array $route_params)
    {
        $this->route_params = Sanitize::filter($route_params);
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. It's Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction
     * 
     * @param string $name Method name
     * @param array $args Arguments passed to the method
     * @throws \Exception 
     * @return void
     */
    public function __call(string $name, array $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {

            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {
        Files::checkVitalDirectories();
        Session::startSession();

        /**
         * We initiate the $siteBase variable.
         * 
         * Indeed, this variable can we used from every controller.
         */
        $this->siteBase = SessionConfig::getFullScheme() . $_SERVER['HTTP_HOST'] . '/';
        
        $this->referer = $this->siteBase;
        
        if (Arrays::isKeyPresent('HTTP_REFERER', $_SERVER)){
            $this->referer = $_SERVER['HTTP_REFERER'];
        }
        
        if(!empty($_POST)){
            $_POST = Sanitize::filter('post');
        }
        
        if (!empty($_GET)){
            $_GET  = Sanitize::filter('get');
        }
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {
        
    }

}
