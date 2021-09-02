<?php

namespace modules\entrant\models;

use dictionary\models\DictCompetitiveGroup;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_ais}}".
 *
 * @property integer $id
 * @property integer $incoming_id
 * @property integer $ais_cg
 * @property string $order_name
 * @property string $order_date
 **/

class AisOrderTransfer extends ActiveRecord
{
    public static function tableName()
    {
        return  "{{%ais_transfer_order}}";
    }

    public function getCg() {
        $currentYear = Date("Y");
        $lastYear = $currentYear - 1;

        return $this->hasOne(DictCompetitiveGroup::class, ['ais_id'=> 'ais_cg'])->andWhere(['year' => "$lastYear-$currentYear"]);
    }

    public function getEvent() {
         return EventCg::find()->andWhere(['cg_id'=>$this->cg->id])->all();
    }

    public function getUserAis() {
        return $this->hasOne(UserAis::class, ['incoming_id'=> 'incoming_id']);
    }
}