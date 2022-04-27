<?php


namespace modules\superservice\models\dto\response;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\AccessType("public_method")
 */
class Message
{
    /**
     * @Serializer\Type("string")
     */
    private string $data = "";

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
