<?php


namespace modules\entrant\models;


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
 * @property integer $submitted
 * @property integer $counter
 *
 **/

class Statement extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%statement}}';
    }

    public static  function create($user_id, $faculty_id, $speciality_id,
                                   $special_right, $edu_level,
                                    $submitted,$counter) {
        $statement =  new static();
        $statement->user_id = $user_id;
        $statement->faculty_id = $faculty_id;
        $statement->speciality_id = $speciality_id;
        $statement->edu_level = $edu_level;
        $statement->special_right = $special_right;
        $statement->counter = $counter;
        $statement->submitted = $submitted;
        return $statement;
    }

    public static function find(): StatementQuery
    {
        return new StatementQuery(static::class);
    }


}