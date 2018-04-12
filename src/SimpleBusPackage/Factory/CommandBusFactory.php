<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Factory;

use Averor\SimpleBusPackage\Resolver\InvokableHandlerResolver;
use SimpleBus\Message\Bus\MessageBus;
use SimpleBus\Message\Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
use SimpleBus\Message\CallableResolver\CallableMap;
use SimpleBus\Message\Handler\DelegatesToMessageHandlerMiddleware;
use SimpleBus\Message\Handler\Resolver\NameBasedMessageHandlerResolver;
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
    public static function create(array $map) : MessageBus
    {
        $commandBus = new MessageBusSupportingMiddleware([
            new FinishesHandlingMessageBeforeHandlingNext()
        ]);

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
