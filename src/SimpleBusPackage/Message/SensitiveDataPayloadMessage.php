<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Message;

/**
 * Interface SensitiveDataPayloadMessage
 *
 * @package Averor\SimpleBusPackage\Message
 * @author Averor <averor.dev@gmail.com>
 */
interface SensitiveDataPayloadMessage
{
    /**
     * @return array
     */
    public function serializeSensitiveDataPayload() : array;
}
