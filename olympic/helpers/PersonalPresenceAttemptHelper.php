<?php

namespace olympic\helpers;

use olympic\helpers\auth\ProfileHelper;
use olympic\models\PersonalPresenceAttempt;
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


    public static function isPersonalAttemptOlympic($olimpId) {
        return PersonalPresenceAttempt::find()->olympic($olimpId)->exists();
    }

    public static function userOfPlacesForCert($user_id, $reward_status, $status_id) {
        $result = ProfileHelper::profileFullName($user_id);
        if ($reward_status) {
            $result .= ' - <br/><strong>';
            $result .=  self::nameOfPlacesOne($reward_status);
            $result .= '</strong>';
        } elseif ($status_id) {
            $result .= '<strong>';
            $result .= '- участник приглашен на очный тур';
            $result .= '</strong>';
        }
        return $result;
    }

}