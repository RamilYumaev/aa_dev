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
 *
 **/

class PassExam extends ActiveRecord
{
    const SUCCESS = 1;
    const DANGER = 2;
    const MESSAGE = 'message';

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

    public function countFiles() {
        return $this->getFiles()->count();
    }

    public function countFilesSend() {
        return $this->getFiles()->andWhere(['status' => FileHelper::STATUS_SEND])->count();
    }
}