<?php

return [
    'providers' => [
        kuiper\boot\providers\WebApplicationProvider::class,
        kuiper\boot\providers\TwigViewProvider::class,
        kuiper\boot\providers\MonologProvider::class,
        winwin\providers\DbConnectionProvider::class,
        winwin\petClinic\PetClinicServiceProvider::class,
    ],
    'database' => [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => getenv('DB_PORT') ?: 3306,
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASS') ?: '',
        'dbname' => getenv('DB_NAME'),
        'charset' => getenv('DB_CHARSET') ?: 'utf8',
        'logging' => getenv('DB_LOGGING') == 'true',
    ],
    'base_path' => realpath(__DIR__.'/..'),
    'runtime_path' => '{app.base_path}/runtime',
    'views_path' => '{app.base_path}/resources/views',
    'static_base_uri' => 'http://cdn.17gaoda.com/winwin/0.1.0/pet-clinic',
    'dev_mode' => (getenv('APP_DEV_MODE') === 'true'),
];
