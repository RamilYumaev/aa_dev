<?php
namespace dictionary\helpers;


use dictionary\models\DictSchools;
use dictionary\models\DictSchoolsPreModeration;

class DictSchoolsHelper
{
    public static function schoolName($key): ?string
    {
        return self::find($key)->name ?? null;
    }

    public static function schoolEmail($key): ?string
    {
        return  self::find($key)->email ?? null;
    }

    protected static function find($key): ?DictSchools
    {
        return  DictSchools::findOne($key);
    }

    public static function preSchoolName($key): ?string
    {
        return  DictSchoolsPreModeration::findOne($key)->name ?? null;
    }


}