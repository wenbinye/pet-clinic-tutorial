<?php

return [
    'default' => [
        'name' => 'App',
        'level' => getenv('LOGGER_LEVEL') ?: 'debug',
        'file' => '{app.runtime_path}/default.log',
        'handlers' => [[
            'level' => 'error',
            'file' => '{app.runtime_path}/error.log',
            'allow_inline_line_breaks' => true,
        ]],
    ],
];
