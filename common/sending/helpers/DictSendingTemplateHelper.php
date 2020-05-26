<?php
namespace common\sending\helpers;



use common\sending\models\DictSendingTemplate;
use yii\helpers\ArrayHelper;

class DictSendingTemplateHelper
{
    const CHECK = 1;
    const NO_CHECK = 0;


    public static function checkStatusTypeList()
    {
       return [
            self::NO_CHECK => 'не проверен',
            self::CHECK => 'проверен',
        ];
    }

    public static function templateList(): array
    {
        return ArrayHelper::map(DictSendingTemplate::find()->all(), "id", 'name');
    }

    public static function dictTemplate($type, $type_sending): ? DictSendingTemplate
    {
        return DictSendingTemplate::findOne(['type' => $type, 'type_sending' => $type_sending]);
    }

    public static function templateName($key): string
    {
        return ArrayHelper::getValue(self::templateList(), $key) ?? "";
    }

    public static function checkStatusList(): array
    {
        return ArrayHelper::map(DictSendingTemplate::find()->all(), "id", 'check_status');
    }

    public static function checkStatusTypeName($key): string
    {
        return ArrayHelper::getValue(self::checkStatusTypeList(), self::checkStatusTypeValue($key)) ?? "";
    }

    public static function checkStatusTypeValue($key): string
    {
        return ArrayHelper::getValue(self::checkStatusList(), $key)  ?? "";
    }

    public static function isSending($key): string
    {
        return ArrayHelper::getValue(self::checkStatusList(), $key)  ?? "";
    }






}