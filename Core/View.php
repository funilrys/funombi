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
 * Class View | Core/View.php
 *
 * @package     funombi\Core
 * @author      Nissar Chababy <contact at funilrys dot com>
 * @version     1.0.0
 * @copyright   Copyright (c) 2017-2018, Nissar Chababy
 */

namespace Core;

use Core\Files;

/**
 * Main logic behind the call and usage of Views.
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class View
{

    /**
     * Render a view file.
     *
     * @param string $view The view file must be under App/Views/
     * @param array $args Associative array of data to display in the view (optional)
     * @return void
     */
    public static function render(string $view, array $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/App/Views/$view";  // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    /**
     * This method provide the logic behind the asset() function under Twig.
     * 
     * @return \Twig_Function
     */
    protected static function twigAsset()
    {
        $assetFunction = new \Twig_Function('asset', function ($asset, $createHTMLObject = false) {
            $dir  = Files::matchExtensionToFileSystem($asset);
            $file = $dir . '/' . $asset;
            Files::createLinkToFile($file, $dir, $createHTMLObject);
        });

        return $assetFunction;
    }

    /**
     * This method provide the logic behind the vendor() function under Twig.
     * 
     * @return \Twig_Function
     */
    protected static function twigVendor()
    {
        $vendorFunction = new \Twig_Function('vendor', function ($vendor, $createHTMLObject = false) {
            $file = 'vendor/' . $vendor;
            $type = Files::matchExtensionToFileSystem($vendor);
            Files::createLinkToFile($file, $type, $createHTMLObject);
        });

        return $vendorFunction;
    }

    /**
     * Render a view template using Twig.
     * 
     * @note If you want to add globals or variables to Twig please report to <b>\App\Models\Twig*.php</b>
     *
     * @param string $template The template file
     * @param array $args Associative array of data to display in the view (optional)
     * @return void
     */
    public static function renderTemplate(string $template, array $args = [])
    {
        static $twig = null;
        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');
            $twig   = new \Twig_Environment($loader);

            if (class_exists('\App\Models\TwigFunctions')) {
                $twigFunctions = new \App\Models\TwigFunctions();

                /**
                 * $twigFunctions->functions must be an array
                 */
                foreach ($twigFunctions->functions as $value) {
                    $twig->addFunction($value);
                }
            }

            if (class_exists('\App\Models\TwigGlobals')) {
                $twigGlobals = new \App\Models\TwigGlobals();

                /**
                 * $twigGlobals->globals must be an associative array
                 */
                foreach ($twigGlobals->globals as $key => $value) {
                    $twig->addGlobal($key, $value);
                }
            }

            $twig->addFunction(static::twigAsset());
            $twig->addFunction(static::twigVendor());

            $twig->addGlobal('current_template', 'themes/' . \App\Config\Locations::THEME_NAME);
        }

        echo $twig->render($template, $args);
    }

}
