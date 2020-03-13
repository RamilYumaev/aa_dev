<?php

namespace dod\helpers;

use dod\models\Dod;
use yii\helpers\ArrayHelper;

class UserDodHelper
{
    const FORM_INTRAMURAL = 1;
    const FORM_LIVE_BROADCAST = 2;

    public static function listParticipationForm(): array
    {
        return [
            self::FORM_INTRAMURAL =>'«Приду  на мероприятие»',
            self::FORM_LIVE_BROADCAST =>'«Посмотрю прямую трансляцию»',
        ];
    }

    public static function nameParticipationForm($key): string
    {
        return ArrayHelper::getValue(self::listParticipationForm(), $key);
    }
}