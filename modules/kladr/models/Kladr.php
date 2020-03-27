<?php

namespace modules\kladr\models;

use yii\db\Query;
use yii\helpers\ArrayHelper;

class Kladr
{
    const TABLE_KLADR_NAME = '{{%kladr_kladr}}';
    const TABLE_STREET_NAME = '{{%kladr_street}}';
    const TABLE_DOMA_NAME = '{{%kladr_doma}}';

    /**
     * Субъекты РФ.
     * @return array
     */
    public static function getRegions()
    {
        $code = '__00000000000';

        $rows = (new Query())
            ->select('NAME, SOCR, CODE')
            ->from(self::TABLE_KLADR_NAME)
            ->where(['like', 'CODE', $code, false])
            ->all();
        return ArrayHelper::map($rows, 'CODE', function ($row) {
            return "{$row['SOCR']}. {$row['NAME']}";
        });
    }

    /**
     * Районы (улусы) республик, краев, областей,
     * автономных областей, автономных округов.
     * @param string $regionCode
     * @return array
     */
    public static function getDistricts($regionCode)
    {
        $code = substr($regionCode, 0, 2) . '___00000000';

        $rows = (new Query())
            ->select('NAME, SOCR, CODE')
            ->from(self::TABLE_KLADR_NAME)
            ->where(['like', 'CODE', $code, false])
            ->all();
        $resultArray = ArrayHelper::map($rows, 'CODE', function ($row) {
            return "{$row['SOCR']}. {$row['NAME']}";
        });
        unset($resultArray[substr($regionCode, 0, 2) . '00000000000']);

        return $resultArray;
    }

    /**
     * Города и поселки городского типа регионального и районного подчинения;
     * сельсоветы (сельские округа, сельские администрации, волости).
     * @param string $districtCode
     * @return array
     */
    public static function getCities($districtCode)
    {
        $code = substr($districtCode, 0, 5) . '___00000';

        $rows = (new Query())
            ->select('NAME, SOCR, CODE')
            ->from(self::TABLE_KLADR_NAME)
            ->where(['like', 'CODE', $code, false])
            ->all();
        $resultArray = ArrayHelper::map($rows, 'CODE', function ($row) {
            return "{$row['SOCR']}. {$row['NAME']}";
        });
        unset($resultArray[substr($districtCode, 0, 5) . '00000000']);

        return $resultArray;
    }

    /**
     * Города и поселки городского типа, подчиненные администрациям городов третьего уровня;
     * сельские населенные пункты.
     * @param string $districtCode
     * @return array
     */
    public static function getVillages($districtCode)
    {
        $code = substr($districtCode, 0, 8) . '___00';

        $rows = (new Query())
            ->select('NAME, SOCR, CODE')
            ->from(self::TABLE_KLADR_NAME)
            ->where(['like', 'CODE', $code, false])
            ->all();
        $resultArray = ArrayHelper::map($rows, 'CODE', function ($row) {
            return "{$row['SOCR']}. {$row['NAME']}";
        });
        unset($resultArray[substr($districtCode, 0, 8) . '00000']);

        return $resultArray;
    }

    /**
     * Улицы городов, поселков городского типа и сельских населенных пунктов.
     * @param string $localityCode
     * @return array
     */
    public static function getStreets($localityCode)
    {
        $code = substr($localityCode, 0, 11) . '____00';

        $rows = (new Query())
            ->select('NAME, SOCR, CODE')
            ->from(self::TABLE_STREET_NAME)
            ->where(['like', 'CODE', $code, false])
            ->all();
        return ArrayHelper::map($rows, 'CODE', function ($row) {
            return "{$row['SOCR']}. {$row['NAME']}";
        });
    }

    /**
     * Дома.
     * @param string $streetCode
     * @return array
     */
    public static function getHouses($streetCode)
    {
        $code = substr($streetCode, 0, 17) . '__';

        $rows = (new Query())
            ->select('NAME, CODE')
            ->from(self::TABLE_DOMA_NAME)
            ->where(['like', 'CODE', $code, false])
            ->all();

        $result = [];
        foreach ($rows as $row) {
            $houses = explode(',', $row['NAME']);
            foreach ($houses as $currentBuilding) {
                $result[$row['CODE'] . '_' . $currentBuilding] = $currentBuilding;
            }
        }

        return $result;
    }

    /**
     * Индекс дома.
     * @param string $houseCode
     * @return string
     */
    public static function getPostcode($houseCode)
    {
        $row = (new Query())
            ->select('INDEX')
            ->from(self::TABLE_DOMA_NAME)
            ->where(['CODE' => strstr($houseCode, '_', true)])
            ->limit(1)
            ->one();

        /** @var array $row */
        return $row ? $row['INDEX'] : '';
    }

    /**
     * Формирование полного алреса из КЛАДР структуры.
     * @param \yii\db\ActiveRecord $model
     * @param string $prefix
     * @return string
     */
    public static function makeFullAddress($model, $prefix)
    {
        $result = '';
        if ($model->{$prefix . 'postcode'}) {
            $result .= $model->{$prefix . 'postcode'} . ', ';
        }
        if ($model->{$prefix . 'region'}) {
            $result .= $model->{$prefix . 'region'} . ', ';
        }
        if ($model->{$prefix . 'district'}) {
            $result .= $model->{$prefix . 'district'} . ', ';
        }
        if ($model->{$prefix . 'city'}) {
            $result .= $model->{$prefix . 'city'} . ', ';
        }
        if ($model->{$prefix . 'village'}) {
            $result .= $model->{$prefix . 'village'} . ', ';
        }
        if ($model->{$prefix . 'street'}) {
            $result .= $model->{$prefix . 'street'} . ', ';
        }
        if ($model->{$prefix . 'house'}) {
            $result .= 'д. ' . $model->{$prefix . 'house'} . ', ';
        }
        if ($model->{$prefix . 'housing'}) {
            $result .= 'корп. ' . $model->{$prefix . 'housing'} . ', ';
        }
        if ($model->{$prefix . 'building'}) {
            $result .= 'стр. ' . $model->{$prefix . 'building'} . ', ';
        }
        if ($model->{$prefix . 'flat'}) {
            $result .= 'кв. ' . $model->{$prefix . 'flat'} . ', ';
        }

        return rtrim($result, ', ');
    }
}
