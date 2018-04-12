<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Message;

use DateTimeInterface;

/**
 * Interface Message
 *
 * @package Averor\SimpleBusPackage\Message
 * @author Averor <averor.dev@gmail.com>
 */
interface Message
{
    /**
     * @param array $payload
     */
    public function __construct(array $payload = []);

    /**
     * @return string
     */
    public function uuid() : string;

    /**
     * @return DateTimeInterface
     */
    public function timestamp() : DateTimeInterface;

    /**
     * @return array
     */
    public function payload() : array;
}
