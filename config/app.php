<?php

return [
    'providers' => [
        kuiper\boot\providers\WebApplicationProvider::class,
        kuiper\boot\providers\TwigViewProvider::class,
        winwin\petClinic\PetClinicServiceProvider::class,
    ],
    'base_path' => realpath(__DIR__.'/..'),
    'runtime_path' => '{app.base_path}/runtime',
    'views_path' => '{app.base_path}/resources/views',
    'static_base_uri' => 'http://cdn.17gaoda.com/winwin/0.1.0/pet-clinic',
    'dev_mode' => (getenv('APP_DEV_MODE') === 'true'),
];
