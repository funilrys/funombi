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

namespace Core\tests\units;

use atoum;
use Core\Arrays as classToTest;

/**
 * Tests for Core\Arrays
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Arrays extends atoum
{

    /**
     * We test the validity of the output of isAssociative()
     */
    public function testIsAssociative()
    {
        $isAssociative = array(
            'hello' => 'world',
            'world' => 'hello'
        );

        $isTooAssociative = array(
            'hello' => array(
                'hello' => 'world',
                'world' => array(
                    'hello' => 'world'
                )
            )
        );

        $isNotAssociative = array('hello', 'world');
        
        $isNotAnArray = 'Hello,World';

        $this
                ->given($array = new classToTest())
                ->then
                    ->boolean($array::isAssociative($isAssociative))
                        ->isTrue()
                    ->boolean($array::isAssociative($isTooAssociative))
                        ->isTrue()
                    ->boolean($array::isAssociative($isNotAssociative))
                        ->isFalse()
                    ->boolean($array::isAssociative($isNotAnArray))
                        ->isFalse()
        ;
    }

    /**
     * We test the validity of the output of renameKey()
     */
    public function testRenameKey()
    {
        $data = array(
            'Hello' => 'Funilrys',
            'How' => 'is',
            'Are' => 'on',
            'You?' => 'Github'
        );
        $toChange = array(
            'How' => 'world',
            'Are' => 'from',
            'You?' => 'Germany'
        );

        $validKeys = array('Hello', 'world', 'from', 'Germany');
        $validValues = array('Funilrys','is','on','Github');
        
        $dataNotArray = 'Hello, world, from,Germany';
        
        $this
                ->given($array = new classToTest())
                ->then
                    ->array($array::renameKey($data, $toChange))
                        ->keys
                            ->isEqualTo($validKeys)
                    ->array($array::renameKey($data, $toChange))
                        ->containsValues($validValues)
                    ->array($array::renameKey($data, $toChange))
                        ->isNotEmpty()
                    ->boolean($array::renameKey($dataNotArray,$toChange))
                        ->isFalse()                 
        ;
    }

}
