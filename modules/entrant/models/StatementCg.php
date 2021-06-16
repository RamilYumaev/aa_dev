<?php

namespace modules\entrant\models;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\queries\StatementCgQuery;
use modules\entrant\models\queries\StatementConsentCgQuery;
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
 * @property integer $count_pages;
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


    public function setCountPages($countPages) {
        $this->count_pages = $countPages;
    }

    public function setStatus($status) {
        $this->status_id = $status;
    }

    public function isStatusDraft() {
        return $this->status_id == StatementHelper::STATUS_DRAFT;
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }


    public function getStatementConsent() {
        return $this->hasMany(StatementConsentCg::class, ['statement_cg_id'=>'id']);
    }

    public function getStatementAgreement() {
        return $this->hasOne(StatementAgreementContractCg::class, ['statement_cg'=>'id']);
    }

    public function getStatementRejection() {
        return $this->hasOne(StatementRejectionCg::class, ['statement_cg'=>'id']);
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

    public function countBudgetConsent() {
        return $this->cg->isBudget() && $this->getStatementConsent()->count() > 2;
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

    public static function find(): StatementCgQuery
    {
        return new StatementCgQuery(static::class);
    }

    public function attributeLabels()
    {
        return ["statement_id" => "Заявление", 'cg_id' => "Конкурсная группа", "status_id" => "Статус"];
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }

    public function countFilesAndCountPagesTrue() {
        return $this->count_pages && $this->count_pages == $this->countFiles();
    }

}