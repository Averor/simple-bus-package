<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Message;

use Averor\SimpleBusPackage\Domain\Identifier;

/**
 * Interface CommandWithIdentifier
 *
 * @package Averor\SimpleBusPackage\Message
 * @author Averor <averor.dev@gmail.com>
 */
interface CommandWithIdentifier extends Command
{
    /**
     * @return Identifier
     */
    public function getIdentifier() : Identifier;
}
