<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Message;

use JsonSerializable;

/**
 * Interface Command
 *
 * @package Averor\SimpleBusPackage\Message
 * @author Averor <averor.dev@gmail.com>
 */
interface Command extends Message, JsonSerializable
{}
