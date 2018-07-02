<?php

namespace winwin\petClinic\controllers;

use kuiper\di\annotation\Inject;
use kuiper\web\ViewInterface;

class IndexController extends \kuiper\web\Controller
{
    /**
     * @Inject
     *
     * @var ViewInterface
     */
    private $view;

    public function index()
    {
        $this->response->getBody()->write($this->view->render('index/welcome.html'));
    }
}
