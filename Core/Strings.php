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
 * Class Strings | Core/Strings.php
 *
 * @package     funombi\Core
 * @author      Nissar Chababy <contact at funilrys dot com>
 * @version     1.0.0
 * @copyright   Copyright (c) 2018, Nissar Chababy
 */

namespace Core;

/**
 * Strings manipulation
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Strings
{

    /**
     * This variable will save the initial string.
     * @var string 
     */
    private $data;

    /**
     * Initiate the string we are working with.
     * @param string $data the string to manipulate.
     */
    public function __construct(string $data)
    {
        $this->data = $data;
    }

    /**
     * Check if the string starts with substring.
     * 
     * @param string $string The initial string.
     * @param string $substring The substring to check.
     * @param bool $strict If false we check with case insensitive.
     * @return boolean
     */
    public function startsWith(string $substring, bool $strict = true)
    {
        if ($strict) {
            return strpos($this->data, $substring, 0) === 0;
        }

        return stripos($this->data, $substring, 0) === 0;
    }

    /**
     * Check if the string ends with substing.
     * 
     * @param string $substring The substring to check.
     * @param bool $strict If false we check with case insensitive.
     * @return boolean
     */
    public function endsWith(string $substring, bool $strict = true)
    {
        $position = strlen($this->data) - strlen($substring);

        if ($strict) {
            return strrpos($this->data, $substring, 0) === $position;
        }

        return strripos($this->data, $substring, 0) === $position;
    }

    /**
     * Check if the substring is present into string.
     * 
     * @param string $substring The substring to check.
     * @param bool $strict If false we check with case insensitive.
     * @return boolean
     */
    public function isPresent(string $substring, bool $strict = true)
    {
        if ($strict) {
            return strpos($this->data, $substring, 0) !== false;
        }

        return stripos($this->data, $substring, 0) !== false;
    }

}
