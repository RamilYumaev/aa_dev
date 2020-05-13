<?php

namespace modules\entrant\models;

use modules\entrant\models\queries\StatementIAQuery;
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
 *
 **/


class StatementIndividualAchievements extends ActiveRecord
{
    const DRAFT = 0;

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

    public function setCountPages($countPages) {
        $this->count_pages = $countPages;
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public static function find(): StatementIAQuery
    {
        return new StatementIAQuery(static::class);
    }


}