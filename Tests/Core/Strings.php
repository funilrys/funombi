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
 * Class Strings | Tests/Core/Strings.php
 *
 * @package     funombi\Core\tests
 * @author      Nissar Chababy <contact at funilrys dot com>
 * @version     1.0.0
 * @copyright   Copyright (c) 2017-2018, Nissar Chababy
 */

namespace Core\tests\units;

use atoum;
use Core\Strings as classToTest;

/**
 * Tests for Core\Strings
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Strings extends atoum
{

    /**
     * We test if endsWith is working correctly.
     */
    public function testStartsWith()
    {
        $string                 = 'Hello World';
        $endsWithStrict       = 'Hello';
        $notStartsWithStrict    = array('World', 'hello', 'ello');
        $endsWithoutStrict    = array('hello', 'Hello', 'HelLo', 'HELLO', 'heLLo');
        $notStartsWithoutStrict = array('world', 'World', 'WORLD', 'eLLO');

        $core = new classToTest($string);
        $this
                ->given($core)
                ->then
                ->boolean($core->startsWith($endsWithStrict, true))
                ->isTrue();

        foreach ($notStartsWithStrict as $value) {
            $this
                    ->given($core)
                    ->then
                    ->boolean($core->startsWith($value, true))
                    ->isFalse();
        }
        foreach ($endsWithoutStrict as $value) {
            $this
                    ->given($core)
                    ->then
                    ->boolean($core->startsWith($value, false))
                    ->isTrue();
        }
        foreach ($notStartsWithoutStrict as $value) {
            $this
                    ->given($core)
                    ->then
                    ->boolean($core->startsWith($value, false))
                    ->isFalse();
        }
    }

    /**
     * We test if endsWith is working correctly.
     */
    public function testEndsWith()
    {
        $string                 = 'Hello World';
        $endsWithStrict       = 'World';
        $notEndsWithStrict    = array('hello', 'ello', 'world', 'WoRld');
        $endsWithoutStrict    = array('world', 'wOrld', 'WoRlD', 'WORLD', 'WoRlD');
        $notEndsWithoutStrict = array('hello', 'orl', 'o Wo', 'WORL');

        $core = new classToTest($string);
        $this
                ->given($core)
                ->then
                ->boolean($core->endsWith($endsWithStrict, true))
                ->isTrue();

        foreach ($notEndsWithStrict as $value) {
            $this
                    ->given($core)
                    ->then
                    ->boolean($core->endsWith($value, true))
                    ->isFalse();
        }
        foreach ($endsWithoutStrict as $value) {
            $this
                    ->given($core)
                    ->then
                    ->boolean($core->endsWith($value, false))
                    ->isTrue();
        }
        foreach ($notEndsWithoutStrict as $value) {
            $this
                    ->given($core)
                    ->then
                    ->boolean($core->endsWith($value, false))
                    ->isFalse();
        }
    }
    
     /**
     * We test if isPresent is working correctly.
     */
    public function testisPresent()
    {
        $string                 = 'Hello World';
        $isPresentWithStrict       = array('World', 'Hello', 'o World', 'llo', 'orld');
        $notIsPresentWithStrict    = array('hello','ELLO', 'world', 'WoRld');
        $isPresentWithoutStrict    = array('world', 'wOrld', 'WoRlD', 'WORLD', 'WoRlD', 'Hello', 'HELLO', 'hELLO','Hell', 'hElLo');
        $notisPresentWithoutStrict = array('funilrys', 'funombi');

        $core = new classToTest($string);
        
        foreach ($isPresentWithStrict as $value) {
             $this
                ->given($core)
                ->then
                ->boolean($core->isPresent($value, true))
                ->isTrue();
        }

        foreach ($notIsPresentWithStrict as $value) {
            $this
                    ->given($core)
                    ->then
                    ->boolean($core->isPresent($value, true))
                    ->isFalse();
        }
        foreach ($isPresentWithoutStrict as $value) {
            $this
                    ->given($core)
                    ->then
                    ->boolean($core->isPresent($value, false))
                    ->isTrue();
        }
        foreach ($notisPresentWithoutStrict as $value) {
            $this
                    ->given($core)
                    ->then
                    ->boolean($core->isPresent($value, false))
                    ->isFalse();
        }
    }

}
