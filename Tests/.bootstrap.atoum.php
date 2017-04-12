<?php

/*
This file will automatically be included before EACH test if -bf/--bootstrap-file argument is not used.

Use it to initialize the tested code, add autoloader, require mandatory file, or anything that needs to be done before EACH test.

More information on documentation:
[en] http://docs.atoum.org/en/latest/chapter3.html#bootstrap-file
[fr] http://docs.atoum.org/fr/latest/lancement_des_tests.html#fichier-de-bootstrap
*/

/*
AUTOLOADER

// composer
require __DIR__ . '/vendor/autoload.php';
*/
$autoloader = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

if (is_file($autoloader)) {
    require $autoloader;
} else {
    echo 'Please install the dependencies with "composer update". If this message persist, please check the permissions of your current project.';
    exit();
}
