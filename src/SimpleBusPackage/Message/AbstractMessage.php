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
    protected $id;

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
        $this->id = Uuid::uuid4()->toString();
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

        $message->id = $data['id'];
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
            'id' => $this->getId(),
            'timestamp' => $this->getTimestamp()->format(DateTimeImmutable::ISO8601),
            'payload' => $this->getPayload()
        ];
    }

    /**
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @return DateTimeInterface
     */
    public function getTimestamp() : DateTimeInterface
    {
        return $this->timestamp;
    }

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
    protected function setPayload(array $payload) : void
    {
        $this->payload = $payload;
    }
}
