<?php
namespace Admin\Model\Log;

use Silex\EventListener\LogListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * 必要なログイングするためのログラッパークラス
 *
 * @author toshiki.iwai
 *
 */
class AdminLogListener extends LogListener
{
    protected function logRequest(Request $request)
    {
        $this->logger->debug('> '.$request->getMethod().' '.$request->getRequestUri());
    }
    protected function logResponse(Response $response)
    {
        if ($response instanceof RedirectResponse) {
            $this->logger->debug('< '.$response->getStatusCode().' '.$response->getTargetUrl());
        } else {
            $this->logger->debug('< '.$response->getStatusCode());
        }
    }
    protected function logException(\Exception $e)
    {
        $message = sprintf('%s: %s (uncaught exception) at %s line %s', get_class($e), $e->getMessage(), $e->getFile(), $e->getLine());

        if ($e instanceof HttpExceptionInterface && $e->getStatusCode() < 500) {
            $this->logger->debug($message, array('exception' => $e));
        } else {
            $this->logger->debug($message, array('exception' => $e));
        }
    }
}