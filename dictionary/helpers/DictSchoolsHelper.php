<?php
namespace dictionary\helpers;


use dictionary\models\DictSchools;
use dictionary\models\DictSchoolsPreModeration;
use yii\helpers\ArrayHelper;

class DictSchoolsHelper
{
    const DRAFT_EMAIL = 0;
    const ACTIVE_EMAIL = 1;

    public static function typesEmail()
    {
        return [
            self::DRAFT_EMAIL => 'Неактуальная, новая, или вообще не было email',
            self::ACTIVE_EMAIL => 'Актуальная',
        ];
    }

    public static function typeEmailName($type): ? string
    {
        return ArrayHelper::getValue(self::typesEmail(), $type);
    }

    public static function schoolName($key): ?string
    {
        return self::find($key)->name ?? null;
    }

    public static function regionName($key): ?string
    {
        $model = self::find($key);
        return $model && $model->region ? $model->region->name : null;
    }

    public static function schoolEmail($key): ?string
    {
        return  self::find($key)->email ?? null;
    }

    public static function schoolEmailAndStatus($key): bool
    {
        return  self::find($key)->email && self::find($key)->status;
    }

    protected static function find($key): ?DictSchools
    {
        return  DictSchools::findOne($key);
    }

    public static function preSchoolName($key): ?string
    {
        return  DictSchoolsPreModeration::findOne($key)->name ?? null;
    }

    public static function preRegionName($key): ?string
    {
        $model = DictSchoolsPreModeration::findOne($key);
        return  $model && $model->dictRegion ? $model->dictRegion->name :null;
    }
}