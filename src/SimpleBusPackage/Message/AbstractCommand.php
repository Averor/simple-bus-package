<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Message;

/**
 * Class AbstractCommand
 *
 * @package Averor\SimpleBusPackage\Message
 * @author Averor <averor.dev@gmail.com>
 */
abstract class AbstractCommand implements Command
{
    /** @var array */
    protected $payload = [];

    /**
     * @return array
     */
    public function getPayload() : array
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     * @return void
     */
    protected function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }
}
