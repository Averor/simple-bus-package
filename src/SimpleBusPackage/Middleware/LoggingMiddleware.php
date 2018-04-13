<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Middleware;

use Averor\SimpleBusPackage\Message\Command;
use Averor\SimpleBusPackage\Message\Event;
use Averor\SimpleBusPackage\Message\Message;
use Averor\SimpleBusPackage\Message\Query;
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
    public function handle($message, callable $next) : void
    {
        switch (true) {

            case ($message instanceof Command):
                $this->handleCommand($message, $next);
                break;

            case ($message instanceof Event):
                $this->handleEvent($message, $next);
                break;

            case ($message instanceof Query):
                $this->handleQuery($message, $next);
                break;

            default:
                $this->logger->warning(
                    sprintf(
                        "Message %s [%s] of unknown type dispatched",
                        get_class($message),
                        $message->uuid()
                    ),
                    [
                        'message' => json_encode($message, JSON_FORCE_OBJECT)
                    ]
                );
                break;
        }
    }

    /**
     * @param Command $message
     * @param callable $next
     * @return void
     * @throws \Throwable
     */
    protected function handleCommand(Command $message, callable $next) : void
    {
        $this->logger->info(
            sprintf(
                "Command %s [%s] dispatched",
                get_class($message),
                $message->uuid()
            ),
            [
                'message' => json_encode($message, JSON_FORCE_OBJECT)
            ]
        );

        try {

            $next($message);

            $this->logger->info(
                sprintf(
                    "Command %s [%s] handled",
                    get_class($message),
                    $message->uuid()
                ),
                []
            );

        } catch (\Throwable $e) {

            $this->logger->error(
                sprintf(
                    "Exception during handling command %s [%s]",
                    get_class($message),
                    $message->uuid()
                ),
                ['exception' => $e]
            );

            throw $e;
        }
    }

    /**
     * @param Event $message
     * @param callable $next
     * @return void
     */
    protected function handleEvent(Event $message, callable $next) : void
    {
        $this->logger->info(
            sprintf(
                "Event %s [%s] dispatched",
                get_class($message),
                $message->uuid()
            ),
            [
                'message' => json_encode($message, JSON_FORCE_OBJECT)
            ]
        );

        try {

            $next($message);

            $this->logger->info(
                sprintf(
                    "Event %s [%s] handled",
                    get_class($message),
                    $message->uuid()
                ),
                []
            );

        } catch (\Throwable $e) {

            $this->logger->error(
                sprintf(
                    "Exception during handling event %s [%s]",
                    get_class($message),
                    $message->uuid()
                ),
                ['exception' => $e]
            );
        }
    }

    /**
     * @param Query $message
     * @param callable $next
     * @return void
     * @throws \Throwable
     */
    protected function handleQuery(Query $message, callable $next) : void
    {
        $this->logger->info(
            sprintf(
                "Query %s [%s] dispatched",
                get_class($message),
                $message->uuid()
            ),
            [
                'message' => json_encode($message, JSON_FORCE_OBJECT)
            ]
        );

        try {

            $next($message);

            $this->logger->info(
                sprintf(
                    "Query %s [%s] handled",
                    get_class($message),
                    $message->uuid()
                ),
                []
            );

        } catch (\Throwable $e) {

            $this->logger->error(
                sprintf(
                    "Exception during handling query %s [%s]",
                    get_class($message),
                    $message->uuid()
                ),
                ['exception' => $e]
            );

            throw $e;
        }
    }
}
