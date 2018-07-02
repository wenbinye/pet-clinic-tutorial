<?php

return [
    'providers' => [
        kuiper\boot\providers\WebApplicationProvider::class,
    ],
    'base_path' => realpath(__DIR__.'/..'),
    'runtime_path' => '{app.base_path}/runtime',
];
