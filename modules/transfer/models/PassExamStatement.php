<?php
namespace modules\transfer\models;


use modules\entrant\helpers\FileHelper;
use modules\transfer\behaviors\FileBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%pass_exam_statement}}".
 *
 * @property integer $id
 * @property integer $pass_exam_id
 **/

class PassExamStatement extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%pass_exam_statement}}';
    }

    public function behaviors()
    {
        return [FileBehavior::class];
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function getPassExam() {
        return $this->hasOne(PassExam::class, ['id'=> 'pass_exam_id']);
    }

    public function countFilesSend() {
        return $this->getFiles()->andWhere(['status' => FileHelper::STATUS_SEND])->count();
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }
}