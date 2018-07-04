<?php

namespace winwin\petClinic\admin\controllers;

use kuiper\di\annotation\Inject;
use kuiper\web\security\AuthInterface;
use winwin\petClinic\controllers\Controller;

class IndexController extends Controller
{
    /**
     * @Inject()
     *
     * @var AuthInterface
     */
    private $auth;

    public function getDefaultVars($page)
    {
        return [
            'user' => $this->auth->getIdentity(),
        ];
    }

    public function index()
    {
        if ($this->auth->isGuest()) {
            $this->redirect('/admin/login');
        }
        $this->render('admin/welcome');
    }
}
