<?php

namespace winwin\petClinic\controllers;

class IndexController extends \kuiper\web\Controller
{
    public function index()
    {
        $this->response->getBody()->write('It works!');
    }
}
