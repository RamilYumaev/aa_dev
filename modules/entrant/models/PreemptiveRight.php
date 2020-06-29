<?php

namespace modules\entrant\models;

use modules\dictionary\helpers\DictDefaultHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%preemptive_right}}".
 *
 * @property integer $other_id
 * @property integer $type_id
 * @property integer $statue_id
 * @property string $message
 **/

class PreemptiveRight extends ActiveRecord
{
    public static function tableName()
    {
        return  "{{%preemptive_right}}";
    }

    public static function create($other_id, $type_id, $status_id) {
        $preemptiveRight = new static();
        $preemptiveRight->other_id = $other_id;
        $preemptiveRight->type_id = $type_id;
        $preemptiveRight->statue_id = $status_id;
        return $preemptiveRight;
    }

    public function setMessage($message) {
        return $this->message = $message;
    }

    public function setStatus($status) {
        return $this->statue_id = $status;
    }

    public function getOtherDocument() {
        return $this->hasOne(OtherDocument::class, ['id'=>'other_id']);
    }

    public function getType() {
        return DictDefaultHelper::preemptiveRightName($this->type_id);
    }

    public function attributeLabels()
    {
        return ["other_id" => "Документ", 'type_id' => "Категории, имеющие ПП", "status_id" => "Статус"];
    }

}