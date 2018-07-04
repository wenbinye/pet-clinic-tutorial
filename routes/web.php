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

    $app->get('/owners/{ownerId:\d+}/pets/new', 'PetController:initCreationForm');
    $app->post('/owners/{ownerId:\d+}/pets/new', 'PetController:processCreationForm');
    $app->get('/pets/{petId:\d+}/edit', 'PetController:initUpdateForm');
    $app->post('/pets/{petId:\d+}/edit', 'PetController:processUpdateForm');

    $app->get("/pets/{petId:\d+}/visits/new", 'VisitController:initNewVisitForm');
    $app->post("/pets/{petId:\d+}/visits/new", 'VisitController:processNewVisitForm');
});

$app->group(['namespace' => 'winwin\petClinic\admin\controllers', 'prefix' => '/admin'], function ($app) {
    /* @var \kuiper\web\RouteRegistrarInterface $app */
    $app->get('/login', 'SignUpController:initLoginForm');
    $app->post('/login', 'SignUpController:processLoginForm');
    $app->get('/logout', 'SignUpController:logout');

    $app->get('[/]', 'IndexController:index');

    $app->get('/vets', 'VetController:index');
    $app->get('/pets', 'PetController:index');
});
