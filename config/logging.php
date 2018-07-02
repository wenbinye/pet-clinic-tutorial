<?php

return [
    'default' => [
        'name' => 'App',
        'level' => getenv('LOGGER_LEVEL') ?: 'debug',
        'file' => '{app.runtime_path}/default.log',
        'error_file' => '{app.runtime_path}/error.log',
    ],
];
