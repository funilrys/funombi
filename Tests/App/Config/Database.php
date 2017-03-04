<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Config\tests\units;

require_once dirname(__DIR__, 3) . '/App/Config/Database.php';

/**
 * Description of Database
 * Models
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Database extends \atoum
{

    public function testDatabase()
    {
   
        $this
            ->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance::DB_HOST)
                    ->isNotEmpty()
                ->string($this->testedInstance::DB_NAME)
                    ->isNotEmpty()
                ->string($this->testedInstance::DB_USER)
                    ->isNotEmpty()
                ->string($this->testedInstance::DB_PASSWORD)
                    ->isNotEmpty()
                ->string($this->testedInstance::TABLE_PREFIX)
                    ->isNotEmpty()
                          
        ;
    }

}
