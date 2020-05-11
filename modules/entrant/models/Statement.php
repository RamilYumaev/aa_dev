<?php
namespace modules\entrant\models;


use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use modules\entrant\models\queries\StatementQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%statement}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $edu_level
 * @property integer $faculty_id
 * @property integer $speciality_id
 * @property integer $special_right
 * @property integer $status
 * @property integer $counter
 * @property integer $count_pages
 *
 **/

class Statement extends ActiveRecord
{

    const DRAFT = 0;

    public static function tableName()
    {
        return '{{%statement}}';
    }

    public static  function create($user_id, $faculty_id, $speciality_id, $special_right, $edu_level, $counter) {
        $statement =  new static();
        $statement->user_id = $user_id;
        $statement->faculty_id = $faculty_id;
        $statement->speciality_id = $speciality_id;
        $statement->edu_level = $edu_level;
        $statement->special_right = $special_right;
        $statement->counter = $counter;
        $statement->status = self::DRAFT;
        return $statement;
    }

    public function setCountPages($countPages) {
        $this->count_pages = $countPages;
    }


    public static function find(): StatementQuery
    {
        return new StatementQuery(static::class);
    }

    public function getStatementCg() {
       return $this->hasMany(StatementCg::class, ['statement_id' => 'id']);
    }

    public function getFaculty() {
        return $this->hasOne(Faculty::class, ['id' => 'faculty_id']);
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }


    public function getSpeciality() {
        return $this->hasOne(DictSpeciality::class, ['id' => 'speciality_id']);
    }

    public function getNumberStatement()
    {
        return ($this->faculty->short ?? $this->faculty_id)."-".
            ($this->speciality->short ?? $this->speciality_id)."-".
            DictCompetitiveGroupHelper::getEduLevelsAbbreviatedShortOne($this->edu_level)."-".
            DictCompetitiveGroupHelper::getSpecialRightShortOne($this->special_right)."-".
            $this->user_id."-".
            $this->counter;

    }

    public function columnIdCg(){
        return $this->getStatementCg()->select(['cg_id'])->column();
    }


}