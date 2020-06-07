<?php

namespace modules\entrant\models;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\queries\StatementAgreementContractCgQuery;
use modules\entrant\models\queries\StatementConsentCgQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%statement_agreement_contract_cg}}".
 *
 * @property integer $id
 * @property integer $statement_cg
 * @property integer $status_id;
 * @property integer $created_at;
 * @property integer $updated_at;
 * @property integer $count_pages
 * @property integer $type
 * @property integer $record_id
 **/

class StatementAgreementContractCg extends ActiveRecord
{
    public static function tableName()
    {
        return  "{{%statement_agreement_contract_cg}}";
    }

    public function behaviors()
    {
        return [TimestampBehavior::class];
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

    public function setType($type) {
        $this->type = $type;
    }

    public function setRecordId($record) {
        $this->record_id = $record;
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

    public function typePersonalOrLegal() {
        return $this->type == 2 || $this->type == 3;
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

    public function getPersonal() {
        return $this->hasOne(PersonalEntity::class, ['id'=>'record_id']);
    }

    public function getLegal() {
        return $this->hasOne(LegalEntity::class, ['id'=>'record_id']);
    }

    public function typeEntrant(){
        return $this->type == 1;
    }

    public function typePersonal(){
        return $this->type == 2 && $this->personal;
    }

    public function typeLegal(){
        return $this->type == 3 && $this->legal;
    }



    public function attributeLabels()
    {
        return ["created_at" => "Дата создания", 'statement_cg' => "Конкурсная группа", "status" => "Статус"];
    }

    public static function find(): StatementAgreementContractCgQuery
    {
        return new StatementAgreementContractCgQuery(static::class);
    }

}