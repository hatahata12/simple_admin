<?php
namespace Admin\Model\Service;

use Monolog\Logger;

class AdminService
{
    private $message;
    private $logger;

    public function __construct(
        $message,
        Logger $logger
    ) {
        $this->message = $message;
        $this->logger = $logger;
    }

    public function execute($param, $logic, $action)
    {
        $result = $logic->{$action}($param);
        return $result;
    }

}
