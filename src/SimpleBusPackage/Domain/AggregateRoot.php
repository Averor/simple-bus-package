<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Domain;

/**
 * Interface AggregateRoot
 *
 * @package Averor\SimpleBusPackage\Domain
 * @author Averor <averor.dev@gmail.com>
 */
interface AggregateRoot
{
    /**
     * @return Identifier
     */
    public function getIdentifier() : Identifier;
}
