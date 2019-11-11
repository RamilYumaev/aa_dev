<?php
namespace dictionary\helpers;


use dictionary\models\DictSchools;

class DictSchoolsHelper
{
    public static function schoolName($key): string
    {
        return  DictSchools::findOne($key)->name;
    }


}