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
 * Class Locations | Tests/App/Config/Locations.php
 *
 * @package     funombi\App\Config\tests\units
 * @author      Nissar Chababy <contact at funilrys dot com>
 * @version     1.0.0
 * @copyright   Copyright (c) 2017, Nissar Chababy
 */

namespace App\Config\tests\units;

use atoum;
use App\Config\Locations as classToTest;

/**
 * Tests of App\Config\Locations
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Locations extends atoum
{

    /**
     * We tests all constants  under App\Config\Locations
     */
    public function testLocations()
    {
        $this
                ->given($loc = new classToTest())
                ->then
                ->string($loc::PUBLIC_DIR)
                ->isNotEmpty()
                ->notContains(DIRECTORY_SEPARATOR)
                ->string($loc::STYLESHEETS)
                ->isNotEmpty()
                ->notContains(DIRECTORY_SEPARATOR)
                ->string($loc::IMAGES)
                ->isNotEmpty()
                ->notContains(DIRECTORY_SEPARATOR)
                ->string($loc::JAVASCRIPTS)
                ->isNotEmpty()
                ->notContains(DIRECTORY_SEPARATOR)
                ->string($loc::THEME_NAME)
                ->isNotEmpty()
                ->notContains(DIRECTORY_SEPARATOR)
                ->string($loc::VENDOR)
                ->isNotEmpty()
                ->contains($loc::PUBLIC_DIR)
                ->contains(DIRECTORY_SEPARATOR)
        ;
    }

}
