<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Lib;

use Inpsyde\MyLovelyUsers\Interfaces\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class MonologLogger implements LoggerInterface
{
    private $logger;

    public function __construct()
    {
        $this->logger = new Logger('MyLovelyUsers');
        $logFilePath = '/log/debug.log';
        $logLevel = Logger::DEBUG;
        $handler = new StreamHandler($logFilePath, $logLevel);
        $this->logger->pushHandler($handler);
    }

    public function logInfo(string $message): void
    {
        $this->logger->info($message);
    }

    public function logError(string $message): void
    {
        $this->logger->error($message);
    }
}
