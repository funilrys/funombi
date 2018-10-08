<?php

/*
 * The MIT License
 *
 * Copyright 2017-2018 Nissar Chababy <contact at funilrys dot com>.
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
 * Class Sessions | App/Config/Sessions.php
 *
 * @package     funombi\App\Config
 * @author      Nissar Chababy <contact at funilrys dot com>
 * @version     1.0.0
 * @copyright   Copyright (c) 2017-2018, Nissar Chababy
 */

namespace App\Config;

/**
 * Sessions configuration.
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Sessions
{

    /**
     * Specifies the name of the session which is used as cookie name. 
     * It should only contain alphanumeric characters. 
     * PHP set it by default to 'PHPSESSID'
     * @var string 
     */
    const SESSION_NAME = 'Hello_World';

    /**
     * Marks the cookie as accessible only through the HTTP protocol. 
     * This means that the cookie won't be accessible by scripting languages, such as JavaScript. 
     * This setting can effectively help to reduce identity theft through XSS attacks.
     * @var bool Default: 'true'
     */
    const HTTP_ONLY = true;

    /**
     * Specifies whether cookies should only be sent over secure connections (HTTPS). 
     * Defaults to false.
     * @var bool Default: 'false'
     */
    const SECURED_COOKIES = false;

}
