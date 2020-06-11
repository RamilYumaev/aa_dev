<?php


namespace modules\entrant\models;


use modules\entrant\behaviors\FileBehavior;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\queries\StatementRejectionCgConsentQuery;
use modules\entrant\models\queries\StatementRejectionQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "{{%statement_rejection_cg_consent}}".
 *
 * @property integer $id
 * @property integer $statement_cg_consent_id
 * @property integer $status_id;
 * @property integer $count_pages;

 **/

class StatementRejectionCgConsent extends ActiveRecord
{
    public static function tableName()
    {
        return  "{{%statement_rejection_cg_consent}}";
    }

    public static function create($statement_id) {
        $statementRejection = new static();
        $statementRejection->statement_cg_consent_id = $statement_id;
        return $statementRejection;
    }

    public function behaviors()
    {
        return [TimestampBehavior::class, FileBehavior::class];
    }


    public function countAcceptedFiles() {
        return $this->getFiles()->andWhere(['status'=>FileHelper::STATUS_ACCEPTED])->count();
    }

    public function isAllFilesAccepted() {
        return $this->countAcceptedFiles() == $this->countFiles();
    }

    public function statusNewJob() {
        return $this->status_id == StatementHelper::STATUS_WALT ||
            $this->status_id == StatementHelper::STATUS_WALT_SPECIAL;
    }


    public function isStatusAccepted() {
        return $this->status_id == StatementHelper::STATUS_ACCEPTED;
    }


    public function getStatementConsentCg() {
        return $this->hasOne(StatementConsentCg::class, ['id'=>'statement_cg_consent_id']);
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

    public function getStatusNameJob() {
        return StatementHelper::statusJobName($this->status_id);
    }

    public function getStatusName() {
        return StatementHelper::statusName($this->status_id);
    }

    public function countFilesAndCountPagesTrue() {
        return $this->count_pages && $this->count_pages == $this->countFiles();
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }


    public function attributeLabels()
    {
        return ["statement_id" => "Заявление", "status_id" => "Статус"];
    }

    public static function find(): StatementRejectionCgConsentQuery
    {
        return new StatementRejectionCgConsentQuery(static::class);
    }

}