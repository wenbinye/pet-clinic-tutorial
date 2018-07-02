<?php

namespace winwin\petClinic;

use kuiper\di\annotation\Inject;
use kuiper\helper\Arrays;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Util\Misc;

class ErrorHandler extends \kuiper\web\ErrorHandler
{
    /**
     * @Inject("app.dev_mode")
     *
     * @var bool
     */
    private $devMode = false;

    public function handle($e)
    {
        if ($this->devMode) {
            return $this->whoopsHandleException($e);
        } else {
            return parent::handle($e);
        }
    }

    protected function whoopsHandleException($e)
    {
        $request = $this->getRequest();
        $server = $request->getServerParams();
        $prettyPageHandler = new PrettyPageHandler();
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
}
