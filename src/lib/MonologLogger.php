<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Lib;

use Inpsyde\MyLovelyUsers\Interfaces\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Class MonologLogger
 *
 * A logger implementation using Monolog library.
 */
class MonologLogger implements LoggerInterface
{
    /** @var Logger The Monolog logger instance. */
    private $logger;

    /**
     * MonologLogger constructor.
     *
     * @param string $logFilePath The path to the log file.
     * @param int    $logLevel    The minimum logging level.
     */
    public function __construct(string $logFilePath, int $logLevel)
    {
        $this->logger = new Logger('MyLovelyUsers');
        $handler = new StreamHandler($logFilePath, $logLevel);
        $this->logger->pushHandler($handler);
    }

    /**
     * Logs an informational message.
     *
     * @param string $message The log message.
     *
     * @return void
     */
    public function logInfo(string $message): void
    {
        $this->logger->info($message);
    }

    /**
     * Logs an error message.
     *
     * @param string $message The error message.
     *
     * @return void
     */
    public function logError(string $message): void
    {
        $this->logger->error($message);
    }
}
