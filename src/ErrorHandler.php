<?php

namespace winwin\petClinic;

use kuiper\di\annotation\Inject;
use kuiper\di\ContainerAwareInterface;
use kuiper\di\ContainerAwareTrait;
use kuiper\helper\Arrays;
use kuiper\web\exception\AccessDeniedException;
use kuiper\web\exception\UnauthorizedException;
use kuiper\web\ViewInterface;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Util\Misc;

class ErrorHandler extends \kuiper\web\ErrorHandler implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @Inject("app.dev_mode")
     *
     * @var bool
     */
    private $devMode = false;

    /**
     * @param \Exception $e
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle($e)
    {
        if ($e instanceof UnauthorizedException) {
            return $this->redirect('/admin/login');
        } elseif ($e instanceof AccessDeniedException) {
            return $this->render('/admin/access_denied.html');
        }
        if ($this->devMode) {
            return $this->whoopsHandleException($e);
        } else {
            return $this->render('error.html', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    protected function whoopsHandleException($e)
    {
        $request = $this->getRequest();
        $server = $request->getServerParams();
        $prettyPageHandler = new PrettyPageHandler();
        $prettyPageHandler->handleUnconditionally(true);
        $prettyPageHandler->addDataTable('Application', [
            'Script Name' => Arrays::fetch($server, 'SCRIPT_NAME'),
        ]);
        $prettyPageHandler->addDataTable('Request', [
            'Accept Charset' => $request->getHeader('ACCEPT_CHARSET') ?: '<none>',
            'Path' => $request->getUri()->getPath(),
            'Query String' => $request->getUri()->getQuery() ?: '<none>',
            'HTTP Method' => $request->getMethod(),
            'Base URL' => (string) $request->getUri(),
            'Scheme' => $request->getUri()->getScheme(),
            'Port' => $request->getUri()->getPort(),
            'Host' => $request->getUri()->getHost(),
        ]);
        $whoops = new \Whoops\Run();
        $whoops->allowQuit(false);
        $whoops->pushHandler($prettyPageHandler);

        // Enable JsonResponseHandler when request is AJAX
        if (Misc::isAjaxRequest()) {
            $whoops->pushHandler(new JsonResponseHandler());
        }

        $whoops->register();
        $handler = \Whoops\Run::EXCEPTION_HANDLER;
        ob_start();
        $whoops->$handler($e);
        $content = ob_get_clean();

        $response = $this->response
                  ->withHeader('Content-type', 'text/html');
        $response->getBody()->write($content);

        return $response;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function render($page, $vars = [])
    {
        try {
            $view = $this->container->get(ViewInterface::class);
            $this->response->getBody()->write($view->render($page, $vars));

            return $this->response;
        } catch (\Exception $e) {
            return parent::handle($e);
        }
    }

    private function redirect($url)
    {
        return $this->response->withStatus(302)->withHeader('location', $url);
    }
}
