<?php
namespace modules\student\helpers;
use yii\helpers\ArrayHelper;

class TypeHelper
{
    const STUDENT_TYPE = 1;
    const TEACHER_TYPE = 3;
    const EMPLOYEE_TYPE = 4;

    public static function typeList(): array
    {
        return [
            self::STUDENT_TYPE => "Учетная запись студента",
            self::TEACHER_TYPE => "Учетная запись преподавателя",
            self::EMPLOYEE_TYPE => "Учетная запись сотрудника",
        ];
    }

    public static function isKey($key): bool
    {
        return array_key_exists($key, self::typeList());
    }
}