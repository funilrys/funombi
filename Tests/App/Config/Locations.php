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

namespace App\Config\tests\units;

require_once dirname(__DIR__, 3) . '/App/Config/Locations.php';

/**
 * Tests of App\Config\Locations
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Locations extends \atoum
{

    /**
     * We tests all constants  under App\Config\Locations
     */
    public function testLocations()
    {
        $this
                ->given($this->newTestedInstance)
                ->then
                    ->string($this->testedInstance::PUBLIC_DIR)
                        ->isNotEmpty()
                    ->string($this->testedInstance::STYLESHEETS)
                        ->isNotEmpty()
                    ->string($this->testedInstance::IMAGES)
                        ->isNotEmpty()
                    ->string($this->testedInstance::JAVASCRIPTS)
                        ->isNotEmpty()
                    ->string($this->testedInstance::THEME_NAME)
                        ->isNotEmpty()
        ;
    }

}
