<?php

namespace winwin\petClinic\admin\controllers;

use kuiper\di\annotation\Inject;
use kuiper\web\security\AuthInterface;

abstract class Controller extends \winwin\petClinic\controllers\Controller
{
    /**
     * @Inject()
     *
     * @var AuthInterface
     */
    protected $auth;

    public function initialize()
    {
        if ($this->auth->isGuest()) {
            $this->redirect('/admin/login');
        }
    }

    protected function getDefaultVars($page)
    {
        return [
            'user' => $this->auth->getIdentity(),
        ];
    }
}
