<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Message;

use DateTimeImmutable;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use ReflectionException;

/**
 * Class AbstractMessage
 *
 * @package Averor\SimpleBusPackage\Message
 * @author Averor <averor.dev@gmail.com>
 */
abstract class AbstractMessage implements Message
{
    /** @var string */
    protected $uuid;

    /** @var DateTimeInterface */
    protected $timestamp;

    /** @var array */
    protected $payload = [];

    /**
     * @param array $payload
     * @throws \Exception
     */
    public function __construct(array $payload = [])
    {
        $this->uuid = Uuid::uuid4()->toString();
        $this->timestamp = new DateTimeImmutable();
        $this->setPayload($payload);
    }

    /**
     * @param array $data
     * @return Message
     * @throws ReflectionException
     * @throws \Exception
     *
     * @todo $data array validation
     */
    public static function restore(array $data) : Message
    {
        $reflection = new \ReflectionClass(get_called_class());

        /** @var AbstractMessage $message */
        $message = $reflection->newInstanceWithoutConstructor();

        $message->uuid = $data['uuid'];
        $message->timestamp = new DateTimeImmutable($data['timestamp']);
        $message->setPayload($data['payload']);

        return $message;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'uuid' => $this->uuid(),
            'timestamp' => $this->timestamp()->format(DateTimeImmutable::ISO8601),
            'payload' => $this->payload()
        ];
    }

    /**
     * @return string
     */
    public function uuid() : string
    {
        return $this->uuid;
    }

    /**
     * @return DateTimeInterface
     */
    public function timestamp() : DateTimeInterface
    {
        return $this->timestamp;
    }

    /**
     * @return array
     */
    public function payload() : array
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     * @return void
     */
    protected function setPayload(array $payload) : void
    {
        $this->payload = $payload;
    }
}
