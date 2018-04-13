<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Message;

use JsonSerializable;

/**
 * Interface Event
 *
 * @package Averor\SimpleBusPackage\Message
 * @author Averor <averor.dev@gmail.com>
 */
interface Event extends Message, JsonSerializable
{}
