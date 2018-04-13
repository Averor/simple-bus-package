<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Middleware;

use Averor\SimpleBusPackage\Exception\CommandHandleException;
use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;

/**
 * Class CommandExceptionHandlingMiddleware
 *
 * @package Averor\SimpleBusPackage\Middleware
 * @author Averor <averor.dev@gmail.com>
 */
class CommandExceptionHandlingMiddleware implements MessageBusMiddleware
{
    /**
     * @param object $message
     * @param callable $next
     * @return void
     */
    public function handle($message, callable $next) : void
    {
        try {
            $next($message);
        } catch (\Throwable $e) {
            throw new CommandHandleException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
