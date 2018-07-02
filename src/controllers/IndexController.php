<?php

namespace winwin\petClinic\controllers;

class IndexController extends Controller
{
    public function index()
    {
        $this->render('index/welcome');
    }
}
