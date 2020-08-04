<?php
namespace modules\exam\models;

use modules\entrant\helpers\DateFormatHelper;
use modules\entrant\models\AdditionalInformation;
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
 * @property string $time
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

    public function data($userId, $src, $time){
        $this->proctor_user_id = $userId;
        $this->src_bbb = $src;
        $this->time = $time;
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

    public function setTime($time)
    {
        $this->time= $time;
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

    public function statusSuccess() {
        return $this->status == ExamStatementHelper::SUCCESS_STATUS;
    }

    public function statusEnd() {
        return $this->status == ExamStatementHelper::END_STATUS;
    }

    public function statusReserve() {
        return $this->status == ExamStatementHelper::RESERVE_STATUS;
    }

    public function statusWalt() {
        return $this->status == ExamStatementHelper::WALT_STATUS;
    }

    public function statusError() {
        return $this->status == ExamStatementHelper::ERROR_RESERVE_STATUS;
    }

    public function typeReserve() {
        return $this->type == ExamStatementHelper::RESERVE_TYPE;
    }

    public function typeZaOch() {
        return $this->type == ExamStatementHelper::USUAL_TYPE_ZA_OCH;
    }

    public function typeOch() {
        return $this->type == ExamStatementHelper::USUAL_TYPE_OCH;
    }

    public function srcDisabled() {
        return $this->statusError() || $this->statusReserve() || $this->statusEnd();
    }



    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата экзамена',
            'time' => 'Время начала',
            'proctor_user_id' => 'Проктор',
            'entrant_user_id' => 'Абитуриент',
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

    public function  getInformation() {
        return $this->hasOne(AdditionalInformation::class, ['user_id'=>'entrant_user_id']);
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
        ".$this->exam->discipline->name.". Получить доступ для прохождения Вы сможете ". DateFormatHelper::formatView($this->date).", перейдя в раздел «Экзамены» по ссылке:";
    }

    public function getDateView() {
        return DateFormatHelper::formatView($this->date);
    }


    public function getTextEmailReserve(){
        return "Вам назначена повторная попытка сдачи вступительного испытания  ".$this->exam->discipline->name.". на ".$this->dateView.".
        Ожидайте, пожалуйста, ссылку на личную виртуальную комнату системы прокторинга МПГУ. Вы также можете увидеть ее в разделе «Экзамены» в личном кабинете поступающего в МПГУ по ссылке";
    }

    public function getUrlExam(){
        return Url::to('@frontendInfo/exam/default/index', true);
    }

    public function setProctor($proctor)
    {
        $this->proctor_user_id = $proctor;
    }

}