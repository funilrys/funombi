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

namespace Core;

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
        $sessionName = Sessions::SESSION_NAME;
        $httponly = Sessions::HTTP_ONLY;
        $secure = Sessions::SECURED_COOKIES;

        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams['lifetime'], $cookieParams['path'], $cookieParams['domain'], $secure, $httponly);

        session_name($sessionName);

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
     * @return boolean
     */
    protected static function isSessionStarted()
    {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                return session_status() === PHP_SESSION_ACTIVE ? true : false;
            } else {
                return session_id() === '' ? true : false;
            }
        }
        return false;
    }

    /**
     * Initiate session variable based on an associative array.
     * 
     * @param array $toCreate
     */
    public static function initSessionVariable($toCreate)
    {
        if (is_array($toCreate)) {
            foreach ($toCreate as $key => $value) {
                $_SESSION[$key] = $value;
            }
        }
    }

}
