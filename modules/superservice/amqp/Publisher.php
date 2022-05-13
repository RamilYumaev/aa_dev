<?php

namespace modules\superservice\amqp;

use modules\superservice\models\dto\request\Message;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;

class Publisher
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;
    private Serializer $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->connection = new AMQPStreamConnection(
            \Yii::$app->params['rabbitmqHost'],
            \Yii::$app->params['rabbitmqPort'],
            \Yii::$app->params['rabbitmqUser'],
            \Yii::$app->params['rabbitmqPassword']
        );
        $this->channel = $this->connection->channel();
        $this->serializer = $serializer;
    }

    public function publish(Message $message, string $exchange, string $routingKey): void
    {
        $amqpMessage = new AMQPMessage($this->serializer->serialize($message), [
            'content_type' => 'application/json',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);
        echo $amqpMessage->body;
        $this->channel->basic_publish($amqpMessage, $exchange, $routingKey);
    }

    /**
     * @throws \Exception
     */
    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
