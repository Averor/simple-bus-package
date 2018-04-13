<?php

declare(strict_types=1);

namespace Averor\SimpleBusPackage\Message;

use Assert\Assert;
use DateTimeImmutable;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use ReflectionException;

/**
 * Trait MessageTrait
 *
 * @package Averor\SimpleBusPackage\Message
 * @author Averor <averor.dev@gmail.com>
 */
trait MessageTrait
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
    final public function __construct(array $payload = [])
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
     */
    final public static function restore(array $data) : Message
    {
        Assert::that($data)
            ->keyExists('uuid', 'Key: uuid does not exist in message data array')
            ->keyExists('timestamp', 'Key: timestamp does not exist in message data array')
            ->keyExists('payload', 'Key: payload does not exist in message data array');

        Assert::that($data['uuid'], 'Value under key: uuid is not valid UUID')
            ->string()
            ->uuid();

        Assert::that($data['timestamp'], 'Value under key: timestamp is not valid ISO8601 date string')
            ->string()
            ->date(\DateTime::ISO8601);

        Assert::that($data['payload'], 'Value under key: payload is not valid array')
            ->isArray();

        $reflection = new \ReflectionClass(static::class);

        /** @var Message|MessageTrait $message */
        $message = $reflection->newInstanceWithoutConstructor();

        $message->uuid = $data['uuid'];
        $message->timestamp = new DateTimeImmutable($data['timestamp']);
        $message->payload = $data['payload'];

        return $message;
    }

    /**
     * @return array
     */
    final public function toArray() : array
    {
        return [
            'name' => get_class($this),
            'uuid' => $this->uuid(),
            'timestamp' => $this->timestamp()->format(DateTimeImmutable::ISO8601),
            'payload' => $this->payload()
        ];
    }

    /**
     * @return string
     */
    final public function uuid() : string
    {
        return $this->uuid;
    }

    /**
     * @return DateTimeInterface
     */
    final public function timestamp() : DateTimeInterface
    {
        return $this->timestamp;
    }

    /**
     * @return array
     */
    final public function payload() : array
    {
        return $this->payload;
    }

    /**
     * @return array
     */
    public function jsonSerialize() : array
    {
        return $this->toArray();
    }

    /**
     * @param array $payload
     * @return void
     */
    abstract protected function setPayload(array $payload) : void;
}
