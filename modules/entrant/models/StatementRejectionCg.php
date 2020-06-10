<?php

namespace modules\entrant\models;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\queries\StatementAgreementContractCgQuery;
use modules\entrant\models\queries\StatementConsentCgQuery;
use modules\entrant\models\queries\StatementRejectionCgQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%statement_rejection_cg}}".
 *
 * @property integer $id
 * @property integer $statement_cg
 * @property integer $status_id;
 * @property integer $created_at;
 * @property integer $updated_at;
 * @property integer $count_pages
 **/

class StatementRejectionCg extends ActiveRecord
{
    public static function tableName()
    {
        return  "{{%statement_rejection_cg}}";
    }


    public function behaviors()
    {
        return [TimestampBehavior::class, FileBehavior::class];
    }

    public static function create($statement_cg) {
        $statementCg = new static();
        $statementCg->statement_cg = $statement_cg;
        return $statementCg;
    }

    public function setCountPages($countPages) {
        $this->count_pages = $countPages;
    }

    public function setStatus($status) {
        $this->status_id = $status;
    }



    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }

    public function countFilesAndCountPagesTrue() {
        return $this->count_pages && $this->count_pages == $this->countFiles();
    }

    public function statusWalt() {
        return $this->status_id == StatementHelper::STATUS_WALT;
    }

    public function statusDraft() {
        return $this->status_id == StatementHelper::STATUS_DRAFT;
    }


    public function statusAccepted() {
        return $this->status_id == StatementHelper::STATUS_ACCEPTED;
    }

    public function getStatementCg() {
      return $this->hasOne(StatementCg::class, ['id'=>'statement_cg']);
    }



    public function attributeLabels()
    {
        return ["created_at" => "Дата создания", 'statement_cg' => "Конкурсная группа", "status" => "Статус"];
    }

    public static function find(): StatementRejectionCgQuery
    {
        return new StatementRejectionCgQuery(static::class);
    }

}