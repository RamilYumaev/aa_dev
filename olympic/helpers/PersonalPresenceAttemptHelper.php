<?php

namespace olympic\helpers;

use olympic\helpers\auth\ProfileHelper;
use olympic\models\OlimpicList;
use olympic\models\PersonalPresenceAttempt;
use phpDocumentor\Reflection\Types\Boolean;
use yii\helpers\ArrayHelper;

class PersonalPresenceAttemptHelper
{
    /**
     * {@inheritdoc}
     */

    const PRESENCE = 1;
    const NON_APPEARANCE = 0;
    const NOMINATION = 0;
    const FIRST_PLACE = 1;
    const SECOND_PLACE = 2;
    const THIRD_PLACE = 3;

    const USER_NEXT_TOUR = 4;

    const MIN_BALL_FIRST_PLACE = 75;
    const MIN_BALL_NO_FIRST_PLACE = 50;


    public static function nameOfPlaces()
    {
        return [
            self::NOMINATION => 'Победитель в номинации',
            self::FIRST_PLACE => 'Победитель',
            self::SECOND_PLACE => 'Призер II степени',
            self::THIRD_PLACE => 'Призер III степени',
        ];
    }

    public static function nameOfPlacesArray()
    {
        return [
            self::NOMINATION,
            self::FIRST_PLACE,
            self::SECOND_PLACE,
            self::THIRD_PLACE,
        ];
    }

    public static function namePlacesArray()
    {
        return [
            self::FIRST_PLACE,
            self::SECOND_PLACE,
            self::THIRD_PLACE,
        ];
    }

    public static function nameOfPlacesArrayAndValue()
    {
        return [
            self::NOMINATION => "",
            self::FIRST_PLACE => "1-е место",
            self::SECOND_PLACE => "2-е место",
            self::THIRD_PLACE => "3-е место",
        ];
    }

    public static function nameOfPlacesOne($key)
    {
        return ArrayHelper::getValue(self::nameOfPlaces(), $key);
    }

    public static function nameOfPlacesValueOne($key)
    {
        return ArrayHelper::getValue(self::nameOfPlacesArrayAndValue(), $key);
    }


    public static function nameOfPlacesForCert()
    {
        return [
            self::NOMINATION => 'победителем в номинации',
            self::FIRST_PLACE => 'победителем',
            self::SECOND_PLACE => 'призером II степени',
            self::THIRD_PLACE => 'призером III степени',
            null => 'участником',
        ];
    }

    public static function nameOfPlacesForCertOne($key)
    {
        return ArrayHelper::getValue(self::nameOfPlacesForCert(), $key);
    }

    public static function exitInPersonalAttempt($userId, $olimpicId): bool
    {
        return PersonalPresenceAttempt::find()->olympic($olimpicId)->user($userId)->exists();
    }


    public static function isPersonalAttemptOlympic($olimpId)
    {
        return PersonalPresenceAttempt::find()->olympic($olimpId)->exists();
    }

    public static function userOfPlacesForCert($user_id, $reward_status, OlimpicList $olympicList)
    {
        $result = ProfileHelper::profileFullName($user_id);
        if ($reward_status !== null && $reward_status != self::USER_NEXT_TOUR) {
            $result .= ' - <br/><strong>';
            $result .= self::nameOfPlacesOne($reward_status);
            $result .= '</strong>';
        }elseif(
            $olympicList->isFormOfPassageDistantInternal()
            && self::exitInPersonalAttempt($user_id, $olympicList->id)
        )
            {

            $result .= '<strong>';
            $result .= '- участник приглашен на очный тур';
            $result .= '</strong>';

    }

        return $result;
    }

}