<?php

namespace modules\entrant\models;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\DictIndividualAchievement;
use modules\entrant\helpers\StatementHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%statement_ia}}".
 *
 * @property integer $id
 * @property integer $statement_individual_id
 * @property integer $individual_id
 * @property integer $status_id
 * @property string $message
 **/

class StatementIa extends ActiveRecord
{
    public static function tableName()
    {
        return  "{{%statement_ia}}";
    }

    public static function create($statement_individual_id, $individual_id, $status_id) {
        $statementCg = new static();
        $statementCg->statement_individual_id = $statement_individual_id;
        $statementCg->individual_id = $individual_id;
        $statementCg->status_id = $status_id;
        return $statementCg;
    }

    public function getDictIndividualAchievement() {
       return $this->hasOne(DictIndividualAchievement::class, ['id'=>'individual_id']);
    }

    public function getUserIndividualAchievements() {
        return $this->hasOne(UserIndividualAchievements::class, ['individual_id'=>'individual_id'])
            ->where(['user_id' =>$this->statementIndividualAchievement->user_id]);
    }

    public function getStatementIndividualAchievement() {
      return $this->hasOne(StatementIndividualAchievements::class, ['id'=>'statement_individual_id']);
    }

    public function setStatus($status) {
        $this->status_id = $status;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function isStatusDraft() {
        return $this->status_id == StatementHelper::STATUS_DRAFT;
    }

    public function isStatusAccepted() {
        return $this->status_id == StatementHelper::STATUS_ACCEPTED
            || $this->status_id == StatementHelper::STATUS_RECALL;
    }

    public function isStatusNoAccepted() {
        return $this->status_id == StatementHelper::STATUS_NO_ACCEPTED;
    }


    public function getStatusNameJob() {
        return StatementHelper::statusJobName($this->status_id);
    }

    public function getStatusName() {
        return StatementHelper::statusName($this->status_id);
    }
    public function attributeLabels()
    {
        return ["statement_id" => "Заявление", 'individual_id' => "Индивдуальное достижение", "status_id" => "Статус"];
    }

    public function getTextEmail() {
        return 'Ваше идивидуальное достижение  "'.$this->dictIndividualAchievement->name.'" принято';
    }

}