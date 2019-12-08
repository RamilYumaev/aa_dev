<?php


namespace olympic\helpers;

use olympic\models\OlimpicNomination;
use yii\helpers\ArrayHelper;

class OlympicNominationHelper
{
    public static function olympicNominationList(): array
    {
        return ArrayHelper::map(OlimpicNomination::find()->all(), "id", 'name');
    }

    public static function olympicNominationListInOlympic($olympic_id)
    {
        return OlimpicNomination::find()->where(['olimpic_id'=> $olympic_id]);
    }

    public static function olympicName($key): string
    {
        return ArrayHelper::getValue(self::olympicNominationList(), $key);
    }
}