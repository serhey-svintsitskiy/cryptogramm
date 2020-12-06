<?php
set_time_limit(960);
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../vendor/autoload.php';
\Sergosv\cryptogramm\Cryptogramm::quickStart(include(__DIR__ . '/../config/cryptorules.php'), __DIR__.'/perm.txt');