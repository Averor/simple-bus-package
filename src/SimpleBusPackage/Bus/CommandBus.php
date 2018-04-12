<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Bus;

use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;

/**
 * Class CommandBus
 *
 * @package Averor\SimpleBusPackage\Bus
 * @author Averor <averor.dev@gmail.com>
 */
class CommandBus extends MessageBusSupportingMiddleware
{}
