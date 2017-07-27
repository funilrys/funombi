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
 * Class Errors | App/Controllers/Errors.php
 *
 * @package     funombi\App\Controllers
 * @author      Nissar Chababy <contact at funilrys dot com>
 * @version     1.0.0
 * @copyright   Copyright (c) 2017, Nissar Chababy
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;

/**
 * Errors controller
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Errors extends Controller
{

    /**
     * Show Error 403
     * Route: /403
     * 
     * @return void
     */
    public function forbiddenAction()
    {
        View::renderTemplate('Errors/403.html.twig');
    }

    /**
     * Show Error 404
     * Route: /404
     * 
     * @return void
     */
    public function notFoundAction()
    {
        View::renderTemplate('Errors/404.html.twig');
    }

    /**
     * Show Error 500
     * Route: /500
     * 
     * @return void
     */
    public function internalServerErrorAction()
    {
        View::renderTemplate('Errors/500.html.twig');
    }

    /**
     * Show Error 502
     * Route: /502
     * 
     * @return void
     */
    public function badGatewayAction()
    {
        View::renderTemplate('Errors/502.html.twig');
    }

    /**
     * Show Error 503
     * Route: /503
     * 
     * @return void
     */
    public function serviceUnavailableAction()
    {
        View::renderTemplate('Errors/503.html.twig');
    }

    /**
     * Show Error 504
     * Route: /504
     * 
     * @return void
     */
    public function gatewayTimeoutAction()
    {
        View::renderTemplate('Errors/504.html.twig');
    }

}
