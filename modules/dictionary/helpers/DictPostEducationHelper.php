<?php

namespace modules\dictionary\helpers;

use modules\dictionary\models\DictPostEducation;
use yii\helpers\ArrayHelper;

class DictPostEducationHelper
{
    public static function listNames(): array
    {
        return ArrayHelper::map(DictPostEducation::find()->orderBy(['name'=>SORT_ASC])->all(), "id", 'name');
    }

    public static function name($key): ?string
    {
        return ArrayHelper::getValue(self::listNames(), $key);
    }

}