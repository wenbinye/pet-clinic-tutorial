<?php

namespace winwin\petClinic\admin\controllers;

class IndexController extends Controller
{
    public function index()
    {
        $this->render('admin/welcome');
    }
}
