<?php

namespace modules\dictionary\helpers;

use modules\dictionary\models\DictCathedra;
use yii\helpers\ArrayHelper;

class DictCathedraHelper
{
    public static function listNames(): array
    {
        return ArrayHelper::map(DictCathedra::find()->orderBy(['name'=>SORT_ASC])->all(), "id", 'name');
    }

    public static function name($key): ?string
    {
        return ArrayHelper::getValue(self::listNames(), $key);
    }

}