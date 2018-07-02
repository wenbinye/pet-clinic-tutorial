<?php

define('APP_PATH', realpath(__DIR__.'/..'));

$loader = require APP_PATH.'/vendor/autoload.php';
if (file_exists(APP_PATH.'/.env')) {
    (new Dotenv\Dotenv(APP_PATH))->load();
}

(new kuiper\boot\Application())
    ->setLoader($loader)
    ->useAnnotations()
    ->loadConfig(APP_PATH.'/config')
    ->bootstrap()
    ->get(\kuiper\web\ApplicationInterface::class)
    ->run();
