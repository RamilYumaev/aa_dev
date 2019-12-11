<?php


namespace common\sending\helpers;


use common\sending\models\DictSendingUserCategory;
use yii\helpers\ArrayHelper;

class DictSendingUserCategoryHelper
{
    public static function categoryList(): array
    {
        return ArrayHelper::map(DictSendingUserCategory::find()->all(), "id", 'name');
    }

    public static function categoryName($key): string
    {
        return ArrayHelper::getValue(self::categoryList(), $key);
    }

}