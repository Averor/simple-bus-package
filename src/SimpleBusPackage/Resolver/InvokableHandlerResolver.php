<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Resolver;

use SimpleBus\Message\CallableResolver\CallableResolver;
use SimpleBus\Message\CallableResolver\Exception\CouldNotResolveCallable;

/**
 * Class InvokableHandlerResolver
 *
 * @package Averor\SimpleBusPackage\Resolver
 * @author Averor <averor.dev@gmail.com>
 */
class InvokableHandlerResolver implements CallableResolver
{
    /**
     * @param $maybeCallable
     * @throws CouldNotResolveCallable
     * @return callable
     */
    public function resolve($maybeCallable)
    {
        return (new $maybeCallable());
    }
}
