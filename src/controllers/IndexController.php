<?php

namespace winwin\petClinic\controllers;

class IndexController extends Controller
{
    public function index()
    {
        $this->logger->info('[IndexController] visit-index');
        $this->render('index/welcome');
    }
}
