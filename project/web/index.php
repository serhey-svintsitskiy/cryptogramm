<?php

use Sergosv\CryptogrammBrutforce\Brutforcer;

require_once '../vendor/autoload.php';

Brutforcer::quickStart(include(__DIR__ . '/../config/cryptorules.php'), __DIR__.'/perm.txt');