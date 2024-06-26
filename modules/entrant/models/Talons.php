<?php

namespace modules\entrant\models;

use common\auth\models\User;
use yii\db\ActiveRecord;

class Talons extends ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_WAITING = 1;
    const STATUS_WORK = 2;
    const STATUS_FINISHED = 3;
    public static function tableName()
    {
        return '{{%talons}}';
    }

    public function rules(){
        return [
            ['name', 'string'],
            [['name', 'date'], 'unique', 'targetAttribute'=> ['name', 'date']],
            ['anketa_id', 'exist', 'targetClass'=>AnketaCi::class, 'targetAttribute'=>['anketa_id'=>'id']],
            [['status', 'num_of_table','anketa_id','entrant_id','user_id'], 'integer']
        ];
    }

    public function getAnketaCi() {
        return $this->hasOne(AnketaCi::class,['id' => 'anketa_id']);
    }

    public function getEntrant() {
        return $this->hasOne(User::class,['id' => 'entrant_id']);
    }

    public function isNew() {
        return $this->status == self::STATUS_NEW;
    }

    public function isWatting() {
        return $this->status == self::STATUS_WAITING;
    }

    public function isWork() {
        return $this->status == self::STATUS_WORK;
    }

    public function attributeLabels()
    {
       return ['name' => 'ФИО абитуриента/Номер', 'date' => 'Дата'];
    }
}