<?php

namespace modules\superservice\models\dto\request;

use JMS\Serializer\Annotation as Serializer;
class Message
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\SkipWhenEmpty
     */
    private string $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;
        return $this;
    }
}
