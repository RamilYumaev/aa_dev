<?php
namespace modules\superservice\handlers;

use modules\superservice\amqp\Serializer;
use modules\superservice\models\dto\response\Message;

class ResponseHandler
{
    private Serializer $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function handle(string $data): void
    {
        /** @var Message $message */
        $message = $this->serializer->deserialize($data, Message::class);
      echo $data;
    }
}
