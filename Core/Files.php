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
 * Class Files | Core/Files.php
 *
 * @package     funombi\Core
 * @author      Nissar Chababy <contact at funilrys dot com>
 * @version     1.0.0
 * @copyright   Copyright (c) 2017, Nissar Chababy
 */

namespace Core;

use App\Config\Locations;

/**
 * File manipulations
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Files
{

    /**
     * Give the current project root path
     * 
     * @return string
     */
    public static function getRoot()
    {
        return dirname(__DIR__, 1) . DIRECTORY_SEPARATOR;
    }

    /**
     * Return a message to inform developer that a directory is not found
     * 
     * @param array $otherDirectories Other directory to check. MUST BE UNDER Locations::PUBLIC_DIR
     * @throws \Exception 
     * @return boolean
     */
    public static function checkVitalDirectories(array $otherDirectories = null)
    {
        $vital = array(
            Locations::STYLESHEETS => static::isDir(static::getRoot() . Locations::STYLESHEETS),
            Locations::JAVASCRIPTS => static::isDir(static::getRoot() . Locations::JAVASCRIPTS),
            Locations::IMAGES => static::isDir(static::getRoot() . Locations::IMAGES)
        );

        /**
         * Add ability to add/check custom directories under Locations::Public_DIR
         */
        if ($otherDirectories !== null && is_array($otherDirectories)) {
            $toCheck = array();

            foreach ($otherDirectories as $value) {
                $toCheck[$value] = static::isDir(static::getRoot() . Locations::PUBLIC_DIR . DIRECTORY_SEPARATOR . $value);
            }


            $vital = array_merge($toCheck, $vital);
        }

        foreach ($vital as $key => $value) {
            /**
             * If it's not found, we return Exception
             */
            if ($value !== true) {
                throw new \Exception("The (vital) directory '" . Locations::PUBLIC_DIR . "/$key' is not found");
            }
        }

        return true;
    }

    /**
     * Match a given film according to it's extension. 
     * Return the directory where it should be located.
     * 
     * @param string $file File to match with
     * 
     * @return string The directory where the given file should be located
     * @throws \Exception Extension is not matched
     */
    public static function matchExtensionToFileSystem($file)
    {
        $regx = array(
            Locations::STYLESHEETS => '/^.*\.(css)$/i',
            Locations::JAVASCRIPTS => '/^.*\.(js)$/i',
            Locations::IMAGES => '/^.*\.(jpg|jpeg|png|gif|ico)$/i'
        );

        foreach ($regx as $key => $value) {
            if (preg_match($value, $file)) {
                return $key;
            }
        }
        throw new \Exception("The extension of $file is not accepted.");
    }

    /**
     * Return a link or an HTML object linked to the desired file according 
     * to $type which come from matchExtensionToFileSystem()
     * 
     * @param string $file File to create Link to
     * @param string $type Type if the file (link =  Locations::STYLESHEETS | script = Locations::JAVASCRIPTS)
     * @param bool $createHTMLObject True: we create full HTML object | False: we return only the generated URL
     * 
     * @throws \Exception Impossible to create HTML object|File not found
     */
    public static function createLinkToFile($file, $type, $createHTMLObject = false)
    {
        $http = \App\Config\Sessions::SECURED_COOKIES ? 'https://' : 'http://';
        $siteURL = $http . $_SERVER['HTTP_HOST'] . explode('index.php', $_SERVER['REDIRECT_URL'])[0];

        if (static::isFile($file) && $createHTMLObject) {
            if ($type === Locations::STYLESHEETS) {
                echo "<link href = \"" . $siteURL . $file . "\" rel=\"stylesheet\" type=\"text/css\">";
            } elseif ($type === Locations::JAVASCRIPTS) {
                echo "<script src=\"" . $siteURL . $file . "\" type=\"text/javascript\"></script>";
            } elseif ($type === Locations::IMAGES) {
                echo $siteURL . $file;
            } else {
                throw new \Exception("Impossible to create an HTLM object for '" . Locations::PUBLIC_DIR . "/$file'");
            }
        } elseif (!$createHTMLObject && static::isFile($file)) {
            echo $siteURL . $file;
        } else {
            throw new \Exception(Locations::PUBLIC_DIR . DIRECTORY_SEPARATOR . "$file is not found");
        }
    }

    /**
     * Check if file exist and is readable
     * 
     * @param string $file File to check existence
     *  
     * @return bool True: Exist and is regular | False: (Don't) Exit or (not) regular
     */
    public static function isFile($file)
    {
        if (is_file($file)) {
            return true;
        }
        return false;
    }

    /**
     * Check if file exist and is readable
     * 
     * @param string $dir Directory to check existence
     * 
     * @return bool True: Exist and is regular | False: (Don't) Exit or (not) regular
     */
    public static function isDir($dir)
    {
        if (is_dir($dir)) {
            return true;
        }
        return false;
    }

    /**
     * Get the hash of a given file
     * 
     * @param string $algo Hash algorithm. Default: 'sha512'
     * @param string $path Path to the file
     * 
     * @return string
     */
    public static function hashFile($path, $algo = 'sha512')
    {
        return hash_file($algo, $path);
    }

    /**
     * Compare master file hash with local file
     * 
     * @param string $file Path to the file
     * @return bool True: File is the default one | False: File has been modified
     */
    public static function isHashSameAsSystem($file)
    {
        $currentHash = static::hashFile($file);

        $filepath = explode(static::getRoot(), $file);
        $file = $filepath[1];

        $systemHash = static::getHashesContent(array($file => 'sha512'))[0];

        if (hash_equals($currentHash, $systemHash)) {
            return true;
        }
        return false;
    }

    /**
     * Read hashes.json and return a readable result
     * Possible algorithms: md5, sha1, sha224, sha384, sha512
     * 
     * @param array $toGet Format: array(path => algorithm)
     * @return array
     */
    public static function getHashesContent($toGet)
    {
        $json = static::getJSON(static::getRoot() . 'hashes.json');
        $hashes = Arrays::flattenKeysRecursively($json);
        $result = array();

        foreach ($toGet as $key => $value) {
            $key = str_replace('/', '.', $key) . '.' . $value;
            $result = array_merge($result, array($hashes[$key]));
        }

        return $result;
    }

    /**
     * Get and read the content of a JSON
     * 
     * @param string $file The file to get
     * @return data|false
     */
    public static function getJSON($file)
    {
        $str = file_get_contents($file);
        $decoded = json_decode($str, true);

        return $decoded;
    }

    /**
     * Write the default data into App\Config\Database
     * 
     * @return boolean
     */
    public static function writeDefaultDatabaseConfig()
    {
        $consts = array(
            'DB_HOST' => 'your-database-host',
            'DB_NAME' => 'your-database-name',
            'DB_USER' => 'your-database-username',
            'DB_PASSWORD' => 'your-database-password',
            'TABLE_PREFIX' => 'your-table-prefix'
        );

        $root = static::getRoot();
        $databaseFile = $root . 'App' . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'Database.php';

        foreach ($consts as $key => $value) {
            $currentFile = file_get_contents($databaseFile);

            $regex = "/const $key = .*;/";
            $replacement = "const $key = '$value';";

            $currentFile = preg_replace($regex, $replacement, $currentFile);

            if (file_put_contents($databaseFile, $currentFile)) {
                continue;
            }
            return false;
        }
        return true;
    }

    /**
     * Function that make it easy to change the defaults credentials of
     * App/Config/Database.php
     * 
     * @param array $data Database credentials | keys, host, name, user, password, prefix
     * @return bool
     */
    public static function writeDatabaseConfig($data)
    {
        if (is_array($data)) {
            $root = static::getRoot();
            $databaseFile = $root . 'App' . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'Database.php';

            $currentFile = file_get_contents($databaseFile);

            if (strpos($currentFile, 'your') !== false) {
                $oldToNew = array(
                    'host' => 'your-database-host',
                    'name' => 'your-database-name',
                    'user' => 'your-database-username',
                    'password' => 'your-database-password',
                    'prefix' => 'your-table-prefix'
                );

                foreach ($oldToNew as $key => $value) {
                    if (isset($data[$key])) {
                        $currentFile = str_replace($value, $data[$key], $currentFile);
                    }
                }

                if (file_put_contents($databaseFile, $currentFile)) {
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }

}
