<?php
namespace Admin\Model\Logic\Admin;

class FreehdLogic
{
    private $message;
    private $logger;

    public function __construct(
        $message,
        $logger
    ) {
        $this->message = $message;
        $this->logger = $logger;
    }

    public function index($requestParam)
    {
        exec('df -m', $output);
        return array('data' => $output);
    }

}
