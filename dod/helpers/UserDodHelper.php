<?php

namespace dod\helpers;

use dod\models\Dod;
use dod\models\UserDod;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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

    public static function userDodDeleteLink($class, UserDod $userDod) {
        return  Html::a('Отменить регистрацию', ['user-dod/delete', 'id' => $userDod->dod_id],
            ['class' => $class, 'data' => ['confirm' => 'Вы действительно хотите отменить?', 'method' => 'POST']]);
    }

}