<?php

namespace modules\entrant\models;
use dictionary\models\DictCompetitiveGroup;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%statement_cg}}".
 *
 * @property integer $id
 * @property integer $statement_id
 * @property integer $cg_id;
 * @property integer $cathedra_id;
 * @property integer $status_id;
 **/

class StatementCg extends ActiveRecord
{
    public static function tableName()
    {
        return  "{{%statement_cg}}";
    }

    public static function create($statement_id, $cg_id, $status_id, $cathedraId =null ) {
        $statementCg = new static();
        $statementCg->statement_id = $statement_id;
        $statementCg->cg_id = $cg_id;
        $statementCg->status_id = $status_id;
        $statementCg->cathedra_id = $cathedraId;
        return $statementCg;
    }

    public function getCg() {
       return $this->hasOne(DictCompetitiveGroup::class, ['id'=>'cg_id']);
    }

    public function getStatement() {
      return $this->hasOne(Statement::class, ['id'=>'statement_id']);
    }

    public function getStatementConsent() {
        return $this->hasMany(StatementConsentCg::class, ['statement_cg_id'=>'id']);
    }

    public function getIsStatementConsent() {
        /* @var $consent  StatementConsentCg */
        foreach ($this->statementConsent as $consent) {
            if($consent->statusAccepted()) {
                try {
                    return \Yii::$app->formatter->asDate($consent->created_at, 'php:Y-m-d H:i:s');
                } catch (InvalidConfigException $e) {
                }
            }
        }
        return null;
    }

    public function getStatementConsentFiles() {
        /* @var $consent \modules\entrant\models\StatementConsentCg */
         foreach ($this->statementConsent as $consent) {
             if($consent->countFiles()) {
                 return true;
             }
         }
         return false;
    }

    public function attributeLabels()
    {
        return ["statement_id" => "Заявление", 'cg_id' => "Конкурсная группа", "status_id" => "Статус"];
    }

}