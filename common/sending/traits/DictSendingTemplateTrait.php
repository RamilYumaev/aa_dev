<?php
namespace common\sending\traits;
use common\sending\models\DictSendingTemplate;

trait DictSendingTemplateTrait
{
    public $name, $html, $text, $check_status, $base_type, $type, $type_sending;

    public function validateRules(): array
    {
        return [
            [['name', 'html', 'text'], 'required'],
            [['html', 'text'], 'string'],
            [['check_status', 'base_type', 'type', 'type_sending'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return DictSendingTemplate::labels();
    }

}