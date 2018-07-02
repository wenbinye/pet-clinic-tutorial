<?php

namespace winwin\petClinic\controllers;

use kuiper\di\annotation\Inject;
use kuiper\web\ViewInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class IndexController extends \kuiper\web\Controller implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @Inject
     *
     * @var ViewInterface
     */
    private $view;

    public function index()
    {
        $this->logger->info('[IndexController] visit-index');
        $this->response->getBody()->write($this->view->render('index/welcome.html'));
    }
}
