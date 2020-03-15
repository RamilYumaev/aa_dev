<?php

namespace modules\entrant\models;


use modules\entrant\models\queries\UserCgQuery;
use yii\db\ActiveRecord;
use \Yii;

/**
 * This is the model class for table "{{%user_cg}}".
 *
 * @property integer $user_id
 * @property string $cg_id
 *
 **/
class UserCg extends ActiveRecord
{

    public static function tableName()
    {
        return "{{user_cg}}";
    }

    public static function create($cgId)
    {
        $model = new static();
        $model->user_id = Yii::$app->user->id;
        $model->cg_id = $cgId;

        return $model;
    }

    public static function find() : UserCgQuery
    {
        return new UserCgQuery(static::class);
    }

}