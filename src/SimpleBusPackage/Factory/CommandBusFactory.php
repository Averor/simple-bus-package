<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Factory;

use Averor\SimpleBusPackage\Bus\CommandBus;
use Averor\SimpleBusPackage\Resolver\InvokableHandlerResolver;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use SimpleBus\Message\Bus\MessageBus;
use SimpleBus\Message\Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext;
use SimpleBus\Message\CallableResolver\CallableMap;
use SimpleBus\Message\Handler\DelegatesToMessageHandlerMiddleware;
use SimpleBus\Message\Handler\Resolver\NameBasedMessageHandlerResolver;
use SimpleBus\Message\Logging\LoggingMiddleware;
use SimpleBus\Message\Name\ClassBasedNameResolver;

/**
 * Class CommandBusFactory
 *
 * @package Averor\SimpleBusPackage\Factory
 * @author Averor <averor.dev@gmail.com>
 */
class CommandBusFactory
{
    /**
     * @param array $map
     * @return MessageBus
     */
    public static function create(array $map, ?LoggerInterface $logger = null) : MessageBus
    {
        $commandBus = new CommandBus([
            new FinishesHandlingMessageBeforeHandlingNext()
        ]);

        if ($logger !== null) {
            $commandBus->appendMiddleware(
                new LoggingMiddleware(
                    $logger,
                    LogLevel::DEBUG
                )
            );
        }

        $commandHandlerMap = new CallableMap(
            $map,
            new InvokableHandlerResolver()
        );

        $commandHandlerResolver = new NameBasedMessageHandlerResolver(
            new ClassBasedNameResolver(),
            $commandHandlerMap
        );

        $commandBus->appendMiddleware(
            new DelegatesToMessageHandlerMiddleware(
                $commandHandlerResolver
            )
        );

        return $commandBus;
    }
}
