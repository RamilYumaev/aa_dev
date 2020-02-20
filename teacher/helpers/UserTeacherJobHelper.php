<?php
namespace teacher\helpers;

use teacher\models\UserTeacherJob;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use function GuzzleHttp\Psr7\normalize_header;

class UserTeacherJobHelper
{

    const DRAFT = 0;
    const WAIT = 1;
    const ACTIVE = 2;

    public static function statusList(): array
    {
        return [
            self::DRAFT => 'Не подтверждено',
            self::WAIT=> 'Ожидание',
            self::ACTIVE => 'Подтверждено',
        ];
    }

    public static function  statusName($key): string
    {
        return ArrayHelper::getValue(self::statusList(), $key);
    }

    public static function columnSchoolId($user_id)
    {
        if (($schoolId = UserTeacherJob::find()->select('school_id')
                ->andWhere(['user_id' => $user_id])->column()) != null) {
            return $schoolId;
            }
        return null;
    }

}