<?php

namespace winwin\petClinic\controllers;

use kuiper\di\annotation\Inject;
use kuiper\web\exception\RedirectException;
use kuiper\web\ViewInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

abstract class Controller extends \kuiper\web\Controller implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    const TEMPLATE_EXTENSION = '.html';

    /**
     * @Inject
     *
     * @var ViewInterface
     */
    protected $view;

    protected function render($page, $vars = [], $return = false)
    {
        $content = $this->view->render($page.self::TEMPLATE_EXTENSION, $vars);
        if ($return) {
            return $content;
        }
        $this->getResponse()->getBody()->write($content);
    }

    protected function redirect($url)
    {
        throw new RedirectException($url);
    }
}
