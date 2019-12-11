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

    public static function templateName($key): string
    {
        return ArrayHelper::getValue(self::templateList(), $key);
    }

    public static function checkStatusList(): array
    {
        return ArrayHelper::map(DictSendingTemplate::find()->all(), "id", 'check_status');
    }

    public static function checkStatusTypeName($key): string
    {
        return ArrayHelper::getValue(self::checkStatusTypeList(), self::checkStatusTypeValue($key));
    }

    public static function checkStatusTypeValue($key): string
    {
        return ArrayHelper::getValue(self::checkStatusList(), $key);
    }

}