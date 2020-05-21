<?php

namespace modules\entrant\models;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\queries\StatementIAQuery;
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
 *
 **/


class StatementIndividualAchievements extends ActiveRecord
{
    const DRAFT = 0;

    public function behaviors()
    {
        return [TimestampBehavior::class];
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

    public function setCountPages($countPages) {
        $this->count_pages = $countPages;
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


    public function getStatementIa() {
        return $this->hasMany(StatementIa::class, ['statement_individual_id' => 'id']);
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


}