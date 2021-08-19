<?php
namespace modules\entrant\helpers;

use modules\entrant\models\Address;
use yii\helpers\ArrayHelper;

class AddressHelper
{
    const TYPE_ACTUAL = 1;
    const TYPE_REGISTRATION = 2;
    const TYPE_RESIDENCE= 3;

    public static function typeOfAddress()
    {
        return [
            self::TYPE_ACTUAL => 'фактический',
            self::TYPE_REGISTRATION => 'постоянный',
            self::TYPE_RESIDENCE => 'временный',
        ];
    }

    public static function rangeAddress()
    {
        return [
            self::TYPE_ACTUAL,
            self::TYPE_REGISTRATION,
            self::TYPE_RESIDENCE,
        ];
    }

    public static function typeName($type): ? string
    {
        if(!is_float($type)) {
            return ArrayHelper::getValue(self::typeOfAddress(), $type);
        }
        return null;
    }

    public static function isExits($user_id): bool
    {
        return Address::find()->andWhere(['user_id' => $user_id, 'type' => self::TYPE_ACTUAL])->exists() &&
            Address::find()->andWhere(['user_id' => $user_id, 'type' => [self::TYPE_REGISTRATION, self::TYPE_RESIDENCE]])->exists();
    }
    public static function isExitsType($user_id, $type): bool
    {
        return Address::find()->andWhere(['user_id' => $user_id,'type' => $type])->exists();
    }

    public static function actual($user_id): array
    {
        return Address::findOne(['user_id' => $user_id,'type' =>self::TYPE_ACTUAL])->dataArray();

    }

    public static function registrationResidence($user_id): array
    {
         $address = Address::find()->andWhere(['user_id' => $user_id, 'type' =>self::TYPE_REGISTRATION])
            ->orWhere(['user_id' => $user_id,'type' => self::TYPE_RESIDENCE])->one();
         return $address ? $address->dataArray() : ['full' => ''];
    }
}