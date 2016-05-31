<?php
namespace Admin\Model\Log;

use Monolog\Handler\StreamHandler;

class ExStreamHandler extends StreamHandler
{
    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        if (!is_resource($this->stream)) {
            if (!$this->url) {
                throw new \LogicException('Missing stream url, the stream can not be opened. This may be caused by a premature call to close().');
            }
            $this->errorMessage = null;
            set_error_handler(array($this, 'customErrorHandler'));
            $this->stream = fopen($this->url, 'a');
            if ($this->filePermission !== null) {
                @chmod($this->url, $this->filePermission);
            }
            restore_error_handler();
            if (!is_resource($this->stream)) {
                $this->stream = null;
                throw new \UnexpectedValueException(sprintf('The stream or file "%s" could not be opened: '.$this->errorMessage, $this->url));
            }
        }
        fwrite($this->stream, (string) $record['formatted']);
    }

    private function customErrorHandler($code, $msg)
    {
        $this->errorMessage = preg_replace('{^fopen\(.*?\): }', '', $msg);
    }
}
