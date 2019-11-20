<?php
namespace dictionary\helpers;


use dictionary\models\DictSchools;
use dictionary\models\DictSchoolsPreModeration;

class DictSchoolsHelper
{
    public static function schoolName($key): ?string
    {
        return  DictSchools::findOne($key)->name ?? null;
    }

    public static function preSchoolName($key): ?string
    {
        return  DictSchoolsPreModeration::findOne($key)->name ?? null;
    }


}