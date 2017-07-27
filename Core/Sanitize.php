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
 * Class Sanitize | Core/Sanitize.php
 *
 * @package     funombi\Core
 * @author      Nissar Chababy <contact at funilrys dot com>
 * @version     1.0.0
 * @copyright   Copyright (c) 2017, Nissar Chababy
 */

namespace Core;

/**
 * Sanitize manipulation
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Sanitize
{

    /**
     * Used to filter/sanitize 'post' ($_POST) and get ($_GET)
     * 
     * @param type $option Format: get | post
     * @param string $toGet If specified return the value of the index = $toGet
     * 
     * @return array Sanitized $_POST or $_GET
     */
    public static function filter($option, $toGet = null)
    {
        if ($option === 'get' && isset($_GET)) {
            $data = $_GET;
        } elseif ($option === 'post' && isset($_POST)) {
            $data = $_POST;

            /**
             * TODO : Find why this line create some errors
             */
            //            array_shift($data);
        } else {
            return false;
        }

        foreach ($data as $key => $value) {
            /**
             * If the $key in $_POST[$key] match the word 'mail'
             * insensitively, we sanitize and return the validated value
             */
            if (preg_match("/mail/mi", $key)) {
                $sanitized = filter_var($value, FILTER_SANITIZE_EMAIL);
                $value = filter_var($sanitized, FILTER_VALIDATE_EMAIL);
            } else {
                $value = filter_var($value, FILTER_SANITIZE_STRING);
            }
            $data[$key] = $value;
        }

        /**
         * Case that we don't want all content of $_POST or $_GET
         */
        if ($toGet !== null) {
            return $data[$toGet];
        }
        return $data;
    }

}
