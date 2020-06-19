<?php

namespace modules\entrant\models;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\queries\StatementConsentCgQuery;
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
 * @property integer $count_pages
 **/

class StatementConsentCg extends ActiveRecord
{
    public static function tableName()
    {
        return  "{{%statement_consent_cg}}";
    }

    public function behaviors()
    {
        return [TimestampBehavior::class, FileBehavior::class];
    }


    public static function create($statement_cg_id, $status_id) {
        $statementCg = new static();
        $statementCg->statement_cg_id = $statement_cg_id;
        $statementCg->status= $status_id;
        return $statementCg;
    }

    public function setCountPages($countPages) {
        $this->count_pages = $countPages;
    }

    public function setStatus($status) {
        $this->status = $status;
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

    public function countAcceptedFiles() {
        return $this->getFiles()->andWhere(['status'=>FileHelper::STATUS_ACCEPTED])->count();
    }

    public function isAllFilesAccepted() {
        return $this->countAcceptedFiles() == $this->countFiles();
    }


    public function statusWalt() {
        return $this->status == StatementHelper::STATUS_WALT;
    }

    public function statusDraft() {
        return $this->status == StatementHelper::STATUS_DRAFT;
    }

    public function statusAccepted() {
        return $this->status == StatementHelper::STATUS_ACCEPTED ||
            $this->status == StatementHelper::STATUS_RECALL;
    }

    public function isStatusAccepted() {
        return $this->status == StatementHelper::STATUS_ACCEPTED;
    }

    public function getStatusNameJob() {
        return StatementHelper::statusJobName($this->status);
    }

    public function getStatusName() {
        return StatementHelper::statusName($this->status);
    }


    public function getStatementCg() {
      return $this->hasOne(StatementCg::class, ['id'=>'statement_cg_id']);
    }

    public function getStatementCgRejection() {
        return $this->hasOne(StatementRejectionCgConsent::class, ['statement_cg_consent_id'=>'id']);
    }

    public function attributeLabels()
    {
        return ["created_at" => "Дата создания", 'statement_cg_id' => "Конкурсная группа", "status_id" => "Статус"];
    }

    public static function find(): StatementConsentCgQuery
    {
        return new StatementConsentCgQuery(static::class);
    }

    public function getTextEmail() {
        return 'Ваше заявление о согласии на зачисление "'.$this->statementCg->cg->fullNameB.'" принято';
    }

}