<?php
namespace testing\helpers;
use testing\models\TestAttempt;
use yii\helpers\ArrayHelper;

class TestAttemptHelper
{
    const NOMINATION = 0;
    const GOLD = 1;
    const SILVER = 2;
    const BRONZE = 3;
    const MEMBER = 4;
    const REWARD_NULL = 5;

    const NO_END_TEST = 0;
    const END_TEST = 1;

    const MIN_BALL_GOLD = 75;
    const MIN_BALL_NO_GOLD = 50;

    public static function count($test){
        return TestAttempt::find()->test($test)->count();
    }

    public static function isAttempt($test, $user){
        return TestAttempt::find()->test($test)->user($user)->exists();
    }

    public static function Attempt($test, $user){
        return TestAttempt::find()->test($test)->user($user)->one();
    }


    public static function nameOfPlaces()
    {
        return [
            self::NOMINATION => 'Победитель в номинации',
            self::GOLD => 'Победитель',
            self::SILVER => 'Призер II степени',
            self::BRONZE => 'Призер III степени',
            self::MEMBER => "Участник следующего тура"
        ];
    }

    public static function nameOfPlacesArray()
    {
        return [
            self::NOMINATION,
            self::GOLD,
            self::SILVER,
            self::BRONZE,
            self::MEMBER
        ];
    }

    public static function nameOfPlacesArrayAndValue()
    {
        return [
            self::NOMINATION => "",
            self::GOLD => "1-е место",
            self::SILVER => "2-е место",
            self::BRONZE => "3-е место",
            self::MEMBER => "Участник следующего тура"
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
            self::GOLD => 'победителем',
            self::SILVER => 'призером II степени',
            self::BRONZE => 'призером III степени',
            null => 'участником заочного тура',
            self::MEMBER => "участником следующего тура"
        ];
    }

    public static function nameOfPlacesForCertOne($key)
    {
        return ArrayHelper::getValue(self::nameOfPlacesForCert(), $key);
    }

}