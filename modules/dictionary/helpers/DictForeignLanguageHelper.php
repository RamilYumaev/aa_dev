<?php

namespace modules\dictionary\helpers;

use modules\dictionary\models\DictForeignLanguage;
use yii\helpers\ArrayHelper;

class DictForeignLanguageHelper
{
    public static function listNames(): array
    {
        return ArrayHelper::map(DictForeignLanguage::find()->orderBy(['name'=>SORT_ASC])->all(), "id", 'name');
    }

    public static function name($key): ?string
    {
        return ArrayHelper::getValue(self::listNames(), $key);
    }

}