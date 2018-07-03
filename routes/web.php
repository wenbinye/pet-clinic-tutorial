<?php

$app->group(['namespace' => 'winwin\petClinic\controllers'], function ($app) {
    /* @var \kuiper\web\RouteRegistrarInterface $app */
    $app->get('/', 'IndexController:index');

    $app->get('/vets', 'VetController:showVetList');
    $app->get('/owners/find', 'OwnerController:initFindForm');
    $app->get('/owners', 'OwnerController:processFindForm');
    $app->get('/owners/{ownerId:\d+}', 'OwnerController:showOwner');
    $app->get('/owners/new', 'OwnerController:initCreationForm');
    $app->post('/owners/new', 'OwnerController:processCreationForm');
    $app->get('/owners/{ownerId:\d+}/edit', 'OwnerController:initUpdateForm');
    $app->post('/owners/{ownerId:\d+}/edit', 'OwnerController:processUpdateForm');
});
