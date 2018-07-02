<?php

$app->group(['namespace' => 'winwin\petClinic\controllers'], function ($app) {
    $app->get('/', 'IndexController:index');

    $app->get('/vets', 'VetController:showVetList');
});
