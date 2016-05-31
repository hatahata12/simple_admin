<?php
namespace Admin\Model\Log;

use Monolog\Formatter\LineFormatter;

class AdminFormatter extends LineFormatter
{
    public function __construct()
    {
        // プロセスIDの取得
        $pid = getmypid();
        $format = "[$pid][%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
        parent::__construct($format);
    }
}