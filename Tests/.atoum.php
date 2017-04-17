<?php

/*
  This file will automatically be included before EACH run.

  Use it to configure atoum or anything that needs to be done before EACH run.

  More information on documentation:
  [en] http://docs.atoum.org/en/latest/chapter3.html#configuration-files
  [fr] http://docs.atoum.org/fr/latest/lancement_des_tests.html#fichier-de-configuration
 */

$autoloader = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

if (is_file($autoloader)) {
    require $autoloader;
} else {
    echo 'Please install the dependencies with "composer update". If this message persist, please check the permissions of your current project.';
    exit();
}

use mageekguy\atoum;

$report = $script->addDefaultReport();

$coverageField = new atoum\report\fields\runner\coverage\html('Funombi', 'Tests/coverage');
//$coverageField->setRootUrl('http://url/of/web/site');

$report->addField($coverageField);

// This will add the atoum logo before each run.
$report->addField(new atoum\report\fields\runner\atoum\logo());

// This will add a green or red logo after each run depending on its status.
$report->addField(new atoum\report\fields\runner\result\logo());

$runner->addTestsFromDirectory('Tests');