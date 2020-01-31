<?php

namespace common\auth\rbac;

use olympic\helpers\auth\ProfileHelper;
use yii\helpers\ArrayHelper;

class Rbac
{
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';
    const ROLE_OLYMPIC_OPERATOR = 'olymp_operator';
    const ROLE_OLYMPIC_TEACHER = 'olympic_teacher';

    public static function roleList(): array
    {
        return [
            ProfileHelper::ROLE_TEACHER => self::ROLE_OLYMPIC_TEACHER,
            ProfileHelper::ROLE_OPERATOR => self::ROLE_OLYMPIC_OPERATOR,
        ];
    }

    public static function roleName($role): string
    {
        return ArrayHelper::getValue(self::roleList(), $role);
    }
}