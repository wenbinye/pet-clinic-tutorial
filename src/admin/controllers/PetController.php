<?php

namespace winwin\petClinic\admin\controllers;

use kuiper\web\annotation\filter\Acl;

/**
 * @Acl("pet:view")
 */
class PetController extends Controller
{
    public function index()
    {
        $this->render('admin/welcome');
    }
}
