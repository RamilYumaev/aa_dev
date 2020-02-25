<?php


namespace modules\entrant\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCountryHelper;
use modules\entrant\helpers\AddressHelper;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $country_id
 * @property integer $type
 * @property string $postcode
 * @property string $region
 * @property string $district
 * @property string $city
 * @property string $village
 * @property string $street
 * @property string $house
 * @property string $housing
 * @property string $building
 * @property string $flat
**/

class Address extends YiiActiveRecordAndModeration
{
    public function behaviors()
    {
        return ['moderation' => [
            'class'=> ModerationBehavior::class,
            'attributes'=>['country_id', 'type', 'postcode', 'region', 'district',
                'city', 'village', 'street', 'house', 'housing', 'building', 'flat']
        ]];
    }

    public static function tableName()
    {
        return "{{%address}}";
    }

    public function titleModeration(): string
    {
        return "Адрес проживания";
    }

    public function moderationAttributes($value): array
    {
        return [
            'country_id' => DictCountryHelper::countryName($value),
            'type' => AddressHelper::typeName($value),
            'postcode' => $value,
            'region' => $value,
            'district' => $value,
            'city' => $value,
            'village' => $value,
            'street' => $value,
            'house' => $value,
            'housing' => $value,
            'building' => $value,
            'flat' => $value
        ];
    }

    public function attributeLabels()
    {
        return [
            'country_id' =>"Страна",
            'type' => "Тип адреса",
            'postcode' => 'Индекс',
            'region' => "Регион",
            'district' => "Район",
            'city' => "Город",
            'village' => "Посёлок",
            'street' => "Улица",
            'house' => "Дом",
            'housing' => "Корпус",
            'building' =>"Строение",
            'flat' => "Квартира",
            ];
    }
}