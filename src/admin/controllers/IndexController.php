<?php

namespace winwin\petClinic\admin\controllers;

use kuiper\di\annotation\Inject;
use kuiper\web\annotation\filter\LoginOnly;
use kuiper\web\security\AuthInterface;
use winwin\petClinic\controllers\Controller;

/**
 * @LoginOnly()
 */
class IndexController extends Controller
{
    /**
     * @Inject()
     *
     * @var AuthInterface
     */
    private $auth;

    protected function getDefaultVars($page)
    {
        return [
            'user' => $this->auth->getIdentity(),
        ];
    }

    public function index()
    {
        $this->render('admin/welcome');
    }
}
