<?php

use winwin\petClinic\admin\constants\Resource;

return [
    'providers' => [
        kuiper\boot\providers\WebApplicationProvider::class,
        kuiper\boot\providers\TwigViewProvider::class,
        kuiper\boot\providers\MonologProvider::class,
        kuiper\boot\providers\ConsoleApplicationProvider::class,
        winwin\providers\DbConnectionProvider::class,
        winwin\providers\ValidatorProvider::class,
        winwin\providers\SwooleServerProvider::class,
        winwin\petClinic\PetClinicServiceProvider::class,
    ],
    'commands' => [
        winwin\petClinic\admin\commands\CreateUserCommand::class,
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
    'swoole_http_server' => [
        'host' => getenv('SWOOLE_SERVER_HOST') ?: '0.0.0.0',
        'port' => getenv('SWOOLE_SERVER_PORT') ?: 8000,
        'worker_num' => getenv('SWOOLE_WORKER_NUM') ?: 1,
    ],
    'session' => [
        'handler' => 'file',
        'built-in' => false,
    ],
    'middlewares' => [
        [kuiper\web\middlewares\Filter::class, 'before:dispatch'],
    ],
    'acl' => [
        'vet' => [Resource::VET_VIEW],
        'pet' => [Resource::PET_VIEW],
    ],
    'base_path' => realpath(__DIR__.'/..'),
    'runtime_path' => '{app.base_path}/runtime',
    'view' => [
        'path' => '{app.base_path}/resources/views',
        'globals' => [
            'static_base_uri' => 'http://cdn.17gaoda.com/winwin/0.1.0/pet-clinic',
            'adminlte_base_uri' => 'http://cdn.17gaoda.com/adminlte/2.3.8',
        ],
    ],
    'dev_mode' => (getenv('APP_DEV_MODE') === 'true'),
];
