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
        return $this->hasOne(DictCompetitiveGroup::class, ['ais_id'=> 'ais_cg']);
    }
}