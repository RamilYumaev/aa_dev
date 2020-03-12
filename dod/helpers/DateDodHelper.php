<?php

namespace dod\helpers;

use dod\models\Dod;
use yii\helpers\ArrayHelper;

class DateDodHelper
{
    const TYPE_INTRAMURAL = 1;
    const TYPE_INTRAMURAL_LIVE_BROADCAST = 2;
    const TYPE_WEBINAR = 3;
    const TYPE_REMOTE = 4;
    const TYPE_HYBRID = 5;
    const TYPE_REMOTE_EDU = 6;

    public static function listTypes(): array
    {
        return [
            self::TYPE_INTRAMURAL =>'очный тип',
            self::TYPE_INTRAMURAL_LIVE_BROADCAST =>'очный тип с прямой трансляцией',
            self::TYPE_WEBINAR => 'вебинар',
            self::TYPE_REMOTE => 'дистанционный тип',
            self::TYPE_HYBRID =>'гибридный тип (очный и дистанционный)',
            self::TYPE_REMOTE_EDU => 'дистанционный для учебных организаций'
        ];
    }

    public static function typeName($key): string
    {
        return ArrayHelper::getValue(self::listTypes(), $key);
    }
}