<?php
namespace modules\transfer\models;


use modules\entrant\helpers\FileHelper;
use modules\transfer\behaviors\FileBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%statement_transfer}}".
 *
 * @property integer $id
 * @property integer $statement_id
 * @property integer $is_pass
 * @property string  $message
 * @property boolean $agree;
 * @property integer $success_exam
 *
 **/

class PassExam extends ActiveRecord
{
    const SUCCESS = 1;
    const DANGER = 2;

    const NO_DATA  = 0;
    const DONE = 2;

    const MESSAGE = 'message';

    public function listType() {
        return [
            self::NO_DATA => 'Нет данных',
            self::SUCCESS => 'Успешно',
            self::DONE => 'Неуспешно',
        ];
    }

    public static function tableName()
    {
        return '{{%pass_exam}}';
    }

    public function rules()
    {
        return [
            ['message','required', 'on'=> self::MESSAGE]
        ];
    }

    public function behaviors()
    {
        return [FileBehavior::class];
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function isPassYes() {
        return $this->is_pass == self::SUCCESS;
    }

    public function isPassNo() {
        return $this->is_pass == self::DANGER;
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function getStatement() {
        return $this->hasOne(StatementTransfer::class, ['id' => 'statement_id']);
    }

    public function getPassExamStatement() {
        return $this->hasOne(PassExamStatement::class, ['pass_exam_id' => 'id']);
    }

    public function getPassExamProtocol() {
        return $this->hasOne(PassExamProtocol::class, ['pass_exam_id' => 'id']);
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }

    public function countFilesSend() {
        return $this->getFiles()->andWhere(['status' => FileHelper::STATUS_SEND])->count();
    }

    public function setSuccessExam($success) {
        $this->success_exam = $success;
    }

    public function isSuccessExam() {
        return $this->success_exam == self::SUCCESS;
    }

    public function getSuccessExam() {
        return $this->listType()[$this->success_exam];
    }
}