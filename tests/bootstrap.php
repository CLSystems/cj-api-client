<?php

error_reporting(E_ALL | E_STRICT);

define('RESOURCE_PATH', (__DIR__) . '/Resources');

require_once 'PHPUnit/TextUI/TestRunner.php';
$loader = require dirname(__DIR__) . '/vendor/autoload.php';