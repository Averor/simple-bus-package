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
    protected $messageId;

    /** @var DateTimeInterface */
    protected $messageTimestamp;

    /** @var array */
    protected $messagePayload = [];

    /**
     * @param array $payload
     * @throws \Exception
     */
    public function __construct(array $payload = [])
    {
        $this->messageId = Uuid::uuid4()->toString();
        $this->messageTimestamp = new DateTimeImmutable();
        $this->setMessagePayload($payload);
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

        $message->messageId = $data['messageId'];
        $message->messageTimestamp = new DateTimeImmutable($data['messageTimestamp']);
        $message->setMessagePayload($data['payload']);

        return $message;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'messageId' => $this->getMessageId(),
            'messageTimestamp' => $this->getMessageTimestamp()->format(DateTimeImmutable::ISO8601),
            'payload' => $this->getMessagePayload()
        ];
    }

    /**
     * @return string
     */
    public function getMessageId() : string
    {
        return $this->messageId;
    }

    /**
     * @return DateTimeInterface
     */
    public function getMessageTimestamp() : DateTimeInterface
    {
        return $this->messageTimestamp;
    }

    /**
     * @return array
     */
    public function getMessagePayload() : array
    {
        return $this->messagePayload;
    }

    /**
     * @param array $payload
     * @return void
     */
    protected function setMessagePayload(array $payload) : void
    {
        $this->messagePayload = $payload;
    }
}
