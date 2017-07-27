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
 * Class Arrays | Core/Arrays.php
 *
 * @package     funombi\Core
 * @author      Nissar Chababy <contact at funilrys dot com>
 * @version     1.0.0
 * @copyright   Copyright (c) 2017, Nissar Chababy
 */

namespace Core;

/**
 * Arrays manipulation
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Arrays
{

    /**
     * Check if an array is associative or not
     * 
     * @param array $array The array to check.
     * @return boolean
     */
    public static function isAssociative(array $array)
    {
        if (array_values($array) !== $array) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Rename key(s) of a given array
     * 
     * @param array $data Original array to rename
     * @param array $toChange Must be associative. Format: array('oldKey' => 'newKey','oldKey2' => 'newKey2')
     * @return bool
     */
    public static function renameKey($data, $toChange)
    {
        if (is_array($data) && static::isAssociative($toChange)) {
            /**
             * We list the original keys
             */
            $originalKeys = array_keys($data);

            $result = array();

            foreach ($toChange as $key => $value) {
                /**
                 * We replace the old key with the new one
                 */
                $originalKeys[array_search($key, $originalKeys)] = $value;

                /**
                 * We combine the keys with their values
                 */
                $result = array_combine($originalKeys, $data);
            }
            return $result;
        }
        return false;
    }

    /**
     * Return a map of the flatten keys with corresponding value.
     * Example: array('Hello' => array('World' => 'Hello)) 
     *      ====> array('Hello.World' => 'Hello')
     * 
     * @param array $array
     * @return array
     */
    public static function flattenKeysRecursively($array)
    {
        $result = [];
        static::_flattenKeyRecursively($array, $result, '');
        return $result;
    }

    /**
     * Helpers of flattenKeysRecursively()
     * 
     * @param array $array
     * @param array $result
     * @param string $parentKey
     */
    private static function _flattenKeyRecursively($array, &$result, $parentKey)
    {
        foreach ($array as $key => $value) {
            $itemKey = ($parentKey ? $parentKey . '.' : '') . $key;
            if (is_array($value)) {
                static::_flattenKeyRecursively($value, $result, $itemKey);
            } else {
                $result[$itemKey] = $value;
            }
        }
    }

}
