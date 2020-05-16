<?php

namespace modules\entrant\models;
use dictionary\models\DictCompetitiveGroup;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%statement_consent_cg}}".
 *
 * @property integer $id
 * @property integer $statement_cg_id
 * @property integer $status;
 * @property integer $created_at;
 * @property integer $updated_at;
 **/

class StatementConsentCg extends ActiveRecord
{
    public static function tableName()
    {
        return  "{{%statement_consent_cg}}";
    }

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    public static function create($statement_cg_id, $status_id) {
        $statementCg = new static();
        $statementCg->statement_cg_id = $statement_cg_id;
        $statementCg->status= $status_id;
        return $statementCg;
    }


    public function getStatementCg() {
      return $this->hasOne(StatementCg::class, ['id'=>'statement_cg_id']);
    }

    public function attributeLabels()
    {
        return ["statement_id" => "Заявление", 'cg_id' => "Конкурсная группа", "status_id" => "Статус"];
    }

}