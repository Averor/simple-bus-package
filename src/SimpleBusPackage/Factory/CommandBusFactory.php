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
    public static function create(array $commandHandlersByCommandName) : MessageBus
    {
        $commandBus = new MessageBusSupportingMiddleware([
            new FinishesHandlingMessageBeforeHandlingNext()
        ]);

        // // Provide a service locator callable. It will be used to instantiate a handler service whenever requested.
        // $serviceLocator = function ($serviceId) {
        //     return $serviceId;
        // };
        //
        // $commandHandlerMap = new CallableMap(
        //     $commandHandlersByCommandName,
        //     new ServiceLocatorAwareCallableResolver($serviceLocator)
        // );

        $commandHandlerMap = new CallableMap(
            $commandHandlersByCommandName,
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
