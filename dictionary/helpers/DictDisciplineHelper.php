<?php


namespace dictionary\helpers;


use dictionary\models\DictDiscipline;
use yii\helpers\ArrayHelper;

class DictDisciplineHelper
{
    public static function disciplineList(): array
    {
        return ArrayHelper::map(DictDiscipline::find()->all(), "id", 'name');
    }

    public static function disciplineName($key): string
    {
        return ArrayHelper::getValue(self::disciplineList(), $key);
    }

}