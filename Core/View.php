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

use Core\Files;

/**
 * Base View
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class View
{

    /**
     * Render a view file
     *
     * @param string $view  The view file must be under App/Views/
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = [])
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
     * Render a view template using Twig
     *
     * @param string $template  The template file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;
        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig_Environment($loader);

            $assetFunction = new \Twig_Function('asset', function ($asset, $createHTMLObject = false) {
                $dir = Files::matchExtensionToFileSystem($asset);
                $file = $dir . '/' . $asset;
                Files::createLinkToFile($file, $dir, $createHTMLObject);
            });

            $vendorFunction = new \Twig_Function('vendor', function ($vendor, $createHTMLObject = false) {
                $dir = 'vendor';
                $file = $dir . '/' . $vendor;
                Files::createLinkToFile($file, $dir, $createHTMLObject);
            });

            $twig->addFunction($assetFunction);
            $twig->addFunction($vendorFunction);
            $twig->addGlobal('currentTheme', 'themes/' . \App\Config\Locations::THEME_NAME);
        }

        echo $twig->render($template, $args);
    }

}
