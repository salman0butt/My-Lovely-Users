<?php

/**
 * Interface LoggerInterface
 *
 * An interface for Logger
 */

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface LoggerInterface
{
    /**
    * Debug level info to log.
    *
    * @param string $message any message to show
    *
    */
    public function logInfo(string $message): void;

    /**
    * Debug level error to log.
    *
    * @param string $message any message to show
    *
    */
    public function logError(string $message): void;
}
