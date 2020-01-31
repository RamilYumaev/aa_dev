<?php
namespace teacher\helpers;

use teacher\models\UserTeacherJob;
use yii\helpers\ArrayHelper;

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

    public static function columnSchoolId()
    {
        try {
            return UserTeacherJob::find()->select('school_id')
            ->andWhere(['status'=> self::ACTIVE, 'user_id'=> \Yii::$app->user->identity->getId()])->column();
        } catch (\DomainException $e) {
            throw new \DomainException('Не найдена ни одна учебная организация. Необходимо добавить');
        }
    }

}