<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Factory;

use Averor\SimpleBusPackage\Message\Message;
use UnexpectedValueException;

/**
 * Class MessageFactory
 *
 * @package Averor\SimpleBusPackage\Factory
 * @author JurekT <jerzy.tuszynski@sprint.pl>
 */
class MessageFactory
{
    /**
     * @param string $fqcn
     * @param array $payload
     * @return Message
     */
    public static function create(string $fqcn, array $payload) : Message
    {
        if (!class_exists($fqcn)) {
            throw new UnexpectedValueException(sprintf(
                'No message class found under name (%s)',
                $fqcn
            ));
        }

        if (!is_subclass_of($fqcn, Message::class)) {
            throw new UnexpectedValueException(sprintf(
                'Class (%s) is not a valid (%s) message class',
                $fqcn,
                Message::class
            ));
        }

        return new $fqcn($payload);
    }
}
