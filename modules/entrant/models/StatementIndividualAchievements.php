<?php

namespace modules\entrant\models;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\queries\StatementIAQuery;
use morphos\S;
use olympic\models\auth\Profiles;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "{{%statement_individual_achievements}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property integer $counter
 * @property integer $edu_level
 * @property integer $count_pages
 * @property integer $created_at;
 * @property integer $updated_at;
 * @property string $message
 *
 **/


class StatementIndividualAchievements extends ActiveRecord
{
    const DRAFT = 0;

    public function behaviors()
    {
        return [TimestampBehavior::class, FileBehavior::class];
    }


    public static function tableName()
    {
        return "{{statement_individual_achievements}}";
    }

    public static function create($user_id,  $edu_level, $counter)
    {
        $statementIA = new static();
        $statementIA->user_id = $user_id;
        $statementIA->edu_level = $edu_level;
        $statementIA->counter = $counter;
        $statementIA->status = self::DRAFT;
        return $statementIA;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function isStatusDraft() {
        return $this->status == StatementHelper::STATUS_DRAFT;
    }

    public function isStatusWalt() {
        return $this->status == StatementHelper::STATUS_WALT;
    }

    public function isStatusAccepted() {
        return $this->status == StatementHelper::STATUS_ACCEPTED
            || $this->status == StatementHelper::STATUS_RECALL;
    }

    public function isStatusNoAccepted() {
        return $this->status == StatementHelper::STATUS_NO_ACCEPTED;
    }


    public function getStatusNameJob() {
        return StatementHelper::statusJobName($this->status);
    }

    public function setCountPages($countPages) {
        $this->count_pages = $countPages;
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }

    public function getProfileUser() {
        return $this->hasOne(Profiles::class, ['user_id' => 'user_id']);
    }

    public function getEduLevel()
    {
        return DictCompetitiveGroupHelper::eduLevelName($this->edu_level);
    }

    public function countAcceptedFiles() {
        return $this->getFiles()->andWhere(['status'=>FileHelper::STATUS_ACCEPTED])->count();
    }

    public function isAllFilesAccepted() {
        return $this->countAcceptedFiles() == $this->countFiles();
    }

    public function statusNewJob() {
        return $this->status == StatementHelper::STATUS_WALT ||
            $this->status == StatementHelper::STATUS_WALT_SPECIAL;
    }

    public function countFilesAndCountPagesTrue() {
        return $this->count_pages && $this->count_pages == $this->countFiles();
    }

    public function getStatusName() {
        return StatementHelper::statusName($this->status);
    }


    public function getStatementIa() {
        return $this->hasMany(StatementIa::class, ['statement_individual_id' => 'id']);
    }

    public function getStatementIaCountNoDraft() {
        return $this->getStatementIa()->andWhere(['status_id'=> StatementHelper::STATUS_WALT])->count();
    }

    public function getStatementIaCountAccepted() {
        return $this->getStatementIa()->andWhere(['status_id'=> StatementHelper::STATUS_ACCEPTED])->count();
    }

    public function getNumberStatement()
    {
        return DictCompetitiveGroupHelper::getEduLevelsAbbreviatedShortOne($this->edu_level)."-".
            $this->user_id."-".
            $this->counter;
    }

    public static function find(): StatementIAQuery
    {
        return new StatementIAQuery(static::class);
    }

    public function attributeLabels()
    {
        return [
            'edu_level' => "Уровень образования",
            'user_id'=> "Абитуриент",
            'created_at' => "Дата создания"
        ];
    }


}