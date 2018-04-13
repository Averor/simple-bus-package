<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Middleware;

use Averor\SimpleBusPackage\Message\Command;
use Averor\SimpleBusPackage\Message\Message;
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
     * @param Message $message
     * @param callable $next
     * @return void
     * @throws \Throwable
     */
    public function handle($message, callable $next)
    {
        if ($message instanceof Command) {
            $this->logger->info(
                sprintf(
                    "Command %s [%s] dispatched",
                    get_class($message),
                    $message->uuid()
                ),
                [
                    'messagedata' => [
                        'id' => $message->uuid(),
                        'timestamp' => $message->timestamp(),
                        'payload' => $message->payload()
                    ]
                ]
            );
        }

        try {

            $next($message);

            if ($message instanceof Command) {
                $this->logger->info(
                    sprintf(
                        "Command %s [%s] handled",
                        get_class($message),
                        $message->uuid()
                    ),
                    []
                );
            }

        } catch (\Throwable $e) {

            if ($message instanceof Command) {
                $this->logger->error(
                    sprintf(
                        "Exception during handling command %s [%s]",
                        get_class($message),
                        $message->uuid()
                    ),
                    ['exception' => $e]
                );
            }

            throw $e;
        }
    }
}
