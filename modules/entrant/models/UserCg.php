<?php

namespace modules\entrant\models;


use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\queries\UserCgQuery;
use yii\db\ActiveRecord;
use \Yii;

/**
 * This is the model class for table "{{%user_cg}}".
 *
 * @property integer $user_id
 * @property integer $cg_id
 * @property integer $cathedra_id
 *
 **/
class UserCg extends ActiveRecord
{

    public static function tableName()
    {
        return "{{user_cg}}";
    }

    public static function create($cgId, $cathedraId = null)
    {
        $model = new static();
        $model->user_id = Yii::$app->user->id;
        $model->cg_id = $cgId;
        $model->cathedra_id = $cathedraId;

        return $model;
    }

    public static function find(): UserCgQuery
    {
        return new UserCgQuery(static::class);
    }


    public function getCg()
    {
        return $this->hasOne(DictCompetitiveGroup::class, ['id' => 'cg_id']);
    }

    public function isMedicine()
    {
        return $this->getCg()->where(['enquiry_086_u_status' => true])->exists();
    }


    public function attributeLabels()
    {
        return ['cg_id' => "Образовательные программы"];
    }

    public function getCompetitiveGroup()
    {
        return $this->hasOne(DictCompetitiveGroup::class, ["id" => "cg_id"]);
    }

}