<?php
namespace modules\dictionary\helpers;

use modules\dictionary\models\DictIncomingDocumentType;
use yii\helpers\ArrayHelper;

class DictIncomingDocumentTypeHelper
{

    const TYPE_EDUCATION = 1;
    const TYPE_PASSPORT = 2;
    const TYPE_MEDICINE= 3;

    const TYPE_EDUCATION_VUZ= 4;
    const TYPE_EDUCATION_PHOTO= 5;
    const TYPE_DIPLOMA= 6;

    public static function listType($type)
    {
        return ArrayHelper::map(self::find($type)->all(), 'id', 'name');
    }

    public static function rangeType($type)
    {
        return self::find($type)->select('id')->column();
    }

    private static function find($type)
    {
        return DictIncomingDocumentType::find()->type($type);
    }

    public static function typeName($type, $key): ? string
    {
        return ArrayHelper::getValue(self::listType($type), $key);
    }


}