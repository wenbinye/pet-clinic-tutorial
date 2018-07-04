<?php

namespace winwin\petClinic\admin\controllers;

use kuiper\web\annotation\filter\Acl;

/**
 * @Acl("vet:view")
 */
class VetController extends Controller
{
    public function index()
    {
        $this->render('admin/welcome');
    }
}
