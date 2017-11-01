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
 * Class Locations | App/Config/Locations.php
 *
 * @package     funombi\App\Config
 * @author      Nissar Chababy <contact at funilrys dot com>
 * @version     1.0.0
 * @copyright   Copyright (c) 2017, Nissar Chababy
 */

namespace App\Config;

/**
 * Establishment of vital directories
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Locations
{

    /**
     * Public directory name.
     * @var string Default: 'public'
     */
    const PUBLIC_DIR = 'public';

    /**
     * Stylesheets directory under $PUBLIC_DIR.
     * @var string Default: 'styles'
     */
    const STYLESHEETS = 'styles';

    /**
     * Images directory under $PUBLIC_DIR.
     * @var string Default: 'images'
     */
    const IMAGES = 'images';

    /**
     * Javascripts  directory under $PUBLIC_DIR.
     * @var string Default: 'js'
     */
    const JAVASCRIPTS = 'js';

    /**
     * Name of the used template.
     * @var string Default: 'ajaz'
     */
    const THEME_NAME = 'ajaz';

    /**
     * Name & location of the vendor directory.
     * @var string Default: "self::PUBLIC_DIR . DIRECTORY_SEPARATOR. 'vendor'"
     */
    const VENDOR = self::PUBLIC_DIR . DIRECTORY_SEPARATOR . 'vendor';

}
