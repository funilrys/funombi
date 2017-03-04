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

require_once dirname(__DIR__, 3) . '/App/Config/Sessions.php';
/**
 * Description of Sessions
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Sessions extends \atoum
{
    public function testSessions()
    {
        $this
            ->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance::SESSION_NAME)
                    ->isNotEmpty()
                    ->match('/^[-_,a-zA-Z0-9]{1,128}$/')
                ->boolean($this->testedInstance::HTTP_ONLY)
                ->boolean($this->testedInstance::SECURED_COOKIES)
        ;
    }
}
