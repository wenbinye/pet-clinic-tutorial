<?php

namespace winwin\petClinic\admin\controllers;

use kuiper\web\annotation\filter\Acl;
use winwin\petClinic\admin\constants\Resource;

/**
 * @Acl(Resource::VET_VIEW)
 */
class VetController extends Controller
{
    public function index()
    {
        $this->render('admin/welcome');
    }
}
