<?php

define('APP_PATH', realpath(__DIR__.'/..'));

$loader = require APP_PATH.'/vendor/autoload.php';

(new kuiper\boot\Application())
    ->setLoader($loader)
    ->useAnnotations()
    ->loadConfig(APP_PATH.'/config')
    ->bootstrap()
    ->get(\kuiper\web\ApplicationInterface::class)
    ->run();
