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
 * Class Session | Core/Session.php
 *
 * @package     funombi\Core
 * @author      Nissar Chababy <contact at funilrys dot com>
 * @version     1.0.0
 * @copyright   Copyright (c) 2017, Nissar Chababy
 */

namespace Core;

use Core\Arrays;
use App\Config\Sessions;

/**
 * $_SESSION manipulation
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Session
{

    /**
     * Start session
     * 
     * @return void
     */
    public static function startSession()
    {
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams['lifetime'], $cookieParams['path'], $cookieParams['domain'], Sessions::SECURED_COOKIES, Sessions::HTTP_ONLY);

        session_name(Sessions::SESSION_NAME);

        if (static::isSessionStarted() === false) {
            session_start();
            session_regenerate_id();
        } else {
            session_regenerate_id();
        }
    }

    /**
     * Destroy current session
     * 
     * @return void
     */
    public static function destroySession()
    {
        session_unset();

        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);

        session_destroy();
    }

    /**
     * Check if session is already started;
     * 
     * @return bool
     */
    protected static function isSessionStarted()
    {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                if (session_status() === PHP_SESSION_ACTIVE) {
                    return true;
                }
                return false;
            } elseif (session_id() === '') {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * Initiate session variable based on an associative array.
     * 
     * @todo Format example
     * @param array $toCreate Variable to create. Format: array('hello' => 'world','world' => 'hello') === $_SESSION['hello'] = 'world'; $_SESSION['world'] = 'hello'
     * @return void
     */
    public static function initSessionVariable(array $toCreate)
    {
        if (Arrays::isAssociative($toCreate)) {
            foreach ($toCreate as $key => $value) {
                $_SESSION[$key] = $value;
            }
        }
    }

    /**
     * Check if a session variable is set
     * 
     * @todo Format example 
     * @param array $data The array which represent the data to check
     * @return boolean
     */
    public static function isSessionVariable(array $data)
    {
        if (is_array($data) && Arrays::isAssociative($data)) {
            foreach ($data as $key => $value) {
                if (isset($_SESSION[$key]) && $_SESSION[$key] !== $value) {
                    return false;
                }
            }
            return true;
        } elseif (is_array($data) && !Arrays::isAssociative($data)) {
            foreach ($data as $value) {
                if (!isset($_SESSION[$value])) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Return the current values of given index(es)
     * 
     * @param array $data An array with a list of index 
     * @return array
     */
    public static function getValues(array $data)
    {
        $results = array();
        if (!Arrays::isAssociative($data)) {
            foreach ($data as $value) {
                $results = array_merge($results, array($value => $_SESSION[$value]));
            }
        }
        return $results;
    }

}
