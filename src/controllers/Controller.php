<?php

namespace winwin\petClinic\controllers;

use kuiper\di\annotation\Inject;
use kuiper\web\ViewInterface;

abstract class Controller extends \kuiper\web\Controller
{
    const TEMPLATE_EXTENSION = '.html';

    /**
     * @Inject
     *
     * @var ViewInterface
     */
    private $view;

    protected function render($page, $vars = [], $return = false)
    {
        $content = $this->view->render($page.self::TEMPLATE_EXTENSION, $vars);
        if ($return) {
            return $content;
        }
        $this->getResponse()->getBody()->write($content);
    }
}
