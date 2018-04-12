<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Message;

/**
 * Interface Message
 *
 * @package Averor\SimpleBusPackage\Message
 * @author JurekT <jerzy.tuszynski@sprint.pl>
 */
interface Message
{
    /**
     * @param array $payload
     */
    public function __construct(array $payload = []);

    /**
     * @return array
     */
    public function getPayload() : array;
}
