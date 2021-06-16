<?php
namespace modules\transfer\models;


use modules\transfer\behaviors\FileBehavior;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\StatementHelper;
use olympic\models\auth\Profiles;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%statement_transfer}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property integer $type
 * @property string  $message
 * @property integer $created_at;
 * @property integer $updated_at;
 * @property integer $count_pages
 *
 **/

class StatementTransfer extends ActiveRecord
{
    const DRAFT = 0;

    public static function tableName()
    {
        return '{{%statement_transfer}}';
    }

    public function behaviors()
    {
        return [TimestampBehavior::class, FileBehavior::class];
    }

    public static  function create($user_id, $type) {
        $statement =  new static();
        $statement->user_id = $user_id;
        $statement->type = $type;
        $statement->status = self::DRAFT;
        return $statement;
    }

    public function setCountPages($countPages) {
        $this->count_pages = $countPages;
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

    public function isStatusAccepted() {
        return $this->status == StatementHelper::STATUS_ACCEPTED
            || $this->status == StatementHelper::STATUS_RECALL;
    }

    public function getStatusNameJob() {
        return StatementHelper::statusJobName($this->status);
    }


    public function getProfileUser() {
        return $this->hasOne(Profiles::class, ['user_id' => 'user_id']);
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function countFiles() {
        return $this->getFiles()->count();
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

    public function statusNewViewJob() {
        return $this->status == StatementHelper::STATUS_WALT ||
            $this->status == StatementHelper::STATUS_WALT_SPECIAL|| $this->status == StatementHelper::STATUS_VIEW;;
    }

    public function statusRecallNoAccepted() {
        return $this->status == StatementHelper::STATUS_RECALL ||
            $this->status == StatementHelper::STATUS_NO_ACCEPTED;
    }

    public function statusNoAccepted() {
        return $this->status == StatementHelper::STATUS_NO_ACCEPTED;
    }

    public function statusAccepted() {
        return $this->status == StatementHelper::STATUS_ACCEPTED;
    }

    public function statusView() {
        return $this->status == StatementHelper::STATUS_VIEW;
    }

    public function countFilesAndCountPagesTrue() {
        return $this->count_pages && $this->count_pages == $this->countFiles();
    }


    public function getStatusName() {
        return  StatementHelper::statusName($this->status);
    }

    public function getNumberStatement()
    {
        return $this->user_id.'-'.$this->type.'-'.date("Y");
    }

    public function attributeLabels()
    {
        return [
            "Условие перевода/восстановления",
            'user_id'=> "Студент",
            'created_at' => "Дата создания"
        ];
    }

}