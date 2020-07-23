<?php
namespace modules\exam\models;

use modules\entrant\helpers\DateFormatHelper;
use modules\exam\helpers\ExamStatementHelper;
use modules\exam\models\queries\ExamAttemptQuery;
use olympic\models\auth\Profiles;
use testing\helpers\TestAttemptHelper;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%exam_statement}}".
 *
 * @property integer $id
 * @property integer $entrant_user_id
 * @property integer $proctor_user_id
 * @property integer $exam_id
 * @property string $date
 * @property integer $type
 * @property string $message
 * @property string $src_bbb
 * @property integer $status
 *
 **/

class ExamStatement extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%exam_statement}}';
    }

    public static function create ($userId, $examId, $date, $type) {
        $exam = new static();
        $exam->entrant_user_id = $userId;
        $exam->date = $date;
        $exam->exam_id = $examId;
        $exam->type = $type;
        return $exam;
    }

    public function data($userId, $src){
        $this->proctor_user_id = $userId;
        $this->src_bbb = $src;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public  function setMessage($message)
    {
        $this->message = $message;
    }

    public function getTypeName() {
        return ExamStatementHelper::listTypes()[$this->type];
    }

    public function getStatusName() {
        return ExamStatementHelper::listStatus()[$this->status];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата экзамена',
            'proctor_user_id' => 'Проктор',
            'entrant_user_id' => 'Абиуриент',
            'proctorFio' => 'Проктор',
            'entrantFio' => 'Абиуриент',
            'src_bbb' => 'Ссылка BigBlueButton',
            'exam_id' => 'Экзамен',
            'status' => 'Статус',
            'type' => "Тип заявки",
            'statusName' => 'Статус',
            'typeName' => "Тип заявки",
            'message'=> "Сообщение"
        ];
    }

    public function getExam() {
        return $this->hasOne(Exam::class, ['id'=>'exam_id']);
    }

    public function getProfileEntrant() {
        return $this->hasOne(Profiles::class, ['user_id'=>'entrant_user_id']);
    }

    public function getProfileProctor() {
        return $this->hasOne(Profiles::class, ['user_id'=>'proctor_user_id']);
    }
    
    public function getProctorFio() {
        return  $this->profileProctor ? $this->profileProctor->fio : null;
    }

    public function getEntrantFio() {
        return $this->profileEntrant ? $this->profileEntrant->fio : null;
    }


    public function getViolation() {
        return $this->hasMany(ExamViolation::class, ['exam_statement_id'=>'id']);
    }

    public function getTextEmailFirst(){
        return "В личном кабинете Вам назначена персональная виртуальная комната для проведения вступительного испытания 
        ".$this->exam->discipline->name.". Получить ее Вы сможете перейдя в раздел «Экзамены» по ссылке";
    }

    public function getTextEmailReserve(){
        return "Вам назначена повторная попытка сдачи вступительного испытания  ".$this->exam->discipline->name.". на ".DateFormatHelper::formatView($this->date)." г. ".$this->exam->timeExam.".
        Ожидайте, пожалуйста, ссылку на личную виртуальную комнату системы прокторинга МПГУ. Вы также можете увидеть ее в разделе «Экзамены» в личном кабинете поступающего в МПГУ по ссылке";
    }

    public function getUrlExam(){
        return Url::to('@frontendInfo/exam/default/index', true);
    }

}