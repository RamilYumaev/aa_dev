<?php

namespace modules\superservice\amqp;

use JMS\Serializer\Serializer as JmsSerializer;
use JMS\Serializer\SerializerBuilder;

class Serializer
{
    private const FORMAT = 'json';

    private JmsSerializer $jmsSerializer;

    public function __construct()
    {
        $this->jmsSerializer = SerializerBuilder::create()
            // ->setCacheDir(\Yii::getAlias('@console/runtime/jms'))
            ->build();
    }

    public function serialize($object): string
    {
        return $this->jmsSerializer->serialize($object, self::FORMAT);
    }

    public function deserialize(string $data, string $type)
    {
        return $this->jmsSerializer->deserialize($data, $type, self::FORMAT);
    }
}
