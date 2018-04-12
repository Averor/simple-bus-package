<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Middleware;

use Averor\SimpleBusPackage\Message\Command;
use Psr\Log\LoggerInterface;
use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;

/**
 * Class LoggingMiddleware
 *
 * @package Averor\SimpleBusPackage\Middleware
 * @author Averor <averor.dev@gmail.com>
 */
class LoggingMiddleware implements MessageBusMiddleware
{
    /** @var LoggerInterface */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param object $message
     * @param callable $next
     * @return void
     * @throws \Throwable
     */
    public function handle($message, callable $next)
    {
        if ($message instanceof Command) {
            $this->logger->info(
                sprintf(
                    "Command '%s' dispatched",
                    get_class($message)
                ),
                ['message' => $message]
            );
        }

        try {

            $next($message);

            if ($message instanceof Command) {
                $this->logger->info(
                    sprintf(
                        "Command '%s' handled",
                        get_class($message)
                    ),
                    []
                );
            }

        } catch (\Throwable $e) {

            if ($message instanceof Command) {
                $this->logger->info(
                    sprintf(
                        "Exception during handling command '%s'",
                        get_class($message)
                    ),
                    ['exception' => $e]
                );
            }

            throw $e;
        }
    }
}
