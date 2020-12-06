<?php

use Sergosv\CryptogrammBrutforce\Factory\BrutforcerFactory;
use Sergosv\CryptogrammBrutforce\Rule\RuleParser;
use Sergosv\CryptogrammBrutforce\Rule\RuleSet;

require_once '../vendor/autoload.php';

$rulesConfigs = include(__DIR__ . '/../config/cryptorules.php');
$brutforcerFactory = new BrutforcerFactory(new RuleParser(), new RuleSet());
$brutforcer = $brutforcerFactory->create($rulesConfigs);
return $brutforcer->calculate();
