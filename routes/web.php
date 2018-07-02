<?php

$app->group(['namespace' => 'winwin\petClinic\controllers'], function ($app) {
    $app->get('/', 'IndexController:index');
});
