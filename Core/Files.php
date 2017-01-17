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

use App\Config\Locations;

/**
 * File manipulations
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Files
{

    /**
     * Return a message to inform developer that a directory is not found
     * 
     * @throws \Exception
     */
    public static function checkVitalDirectories()
    {
        if (static::isDir(Locations::STYLESHEETS) === false) {
            throw new \Exception("The (vital) directory '" . Locations::PUBLIC_DIR . "/" . Locations::STYLESHEETS . "' is not found");
        }
        if (static::isDir(Locations::JAVASCRIPTS) === false) {
            throw new \Exception("The (vital) directory '" . Locations::PUBLIC_DIR . "/" . Locations::JAVASCRIPTS . "' is not found");
        }
        if (static::isDir(Locations::IMAGES) === false) {
            throw new \Exception("The (vital) directory '" . Locations::PUBLIC_DIR . "/" . Locations::IMAGES . "' is not found");
        }
    }

    /**
     * Match a given film according to it's extension. Return the directory 
     * where it should be located.
     * 
     * @param string $file
     * 
     * @return string
     * @throws \Exception Extension is not matched
     */
    public static function matchExtensionToFileSystem($file)
    {
        $regxStyle = '/^.*\.(css)$/i';
        $regxJs = '/^.*\.(js)$/i';
        $regxImage = '/^.*\.(jpg|jpeg|png|gif)$/i';
        if (preg_match($regxStyle, $file)) {
            return Locations::STYLESHEETS;
        } elseif (preg_match($regxJs, $file)) {
            return Locations::JAVASCRIPTS;
        } elseif (preg_match($regxImage, $file)) {
            return Locations::IMAGES;
        } else {
            throw new \Exception("File extention of $file is not accepted.");
        }
    }

    /**
     * Return a link or an HTML object linked to the desired file according 
     * to $type which come from matchExtensionToFileSystem()
     * 
     * @param string $file
     * @param string $type
     * @param boolean $createHTMLObject
     * 
     * @throws \Exception Impossible to create HTML object|File not found
     */
    public static function createLinkToFile($file, $type, $createHTMLObject)
    {
        if (static::isFile($file) === true && $createHTMLObject === true) {
            if ($type === Locations::STYLESHEETS) {
                echo "<link href = \"$file\" rel=\"stylesheet\" type=\"text/css\">";
            } elseif ($type === Locations::JAVASCRIPTS) {
                echo "<script src=\"$file\" type=\"text/javascript\"></script>";
            } else {
                throw new \Exception("Impossible to create an HTLM object for '" . Locations::PUBLIC_DIR . "/$file'");
            }
        } else {
            throw new \Exception("$publicDir/$file is not found");
        }
    }

    /**
     * Check if file exist and is readable
     * 
     * @param string $file
     * 
     * @return boolean
     */
    public static function isFile($file)
    {
        if (is_file($file) === true) {
            return true;
        }
        return false;
    }

    /**
     * Check if file exist and is readable
     * 
     * @param string $dir
     * 
     * @return boolean
     */
    public static function isDir($dir)
    {
        if (is_dir($dir) === true) {
            return true;
        }
        return false;
    }

}
