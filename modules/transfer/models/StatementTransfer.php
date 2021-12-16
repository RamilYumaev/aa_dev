<?php
namespace modules\transfer\models;


use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictClass;
use dictionary\models\DictCompetitiveGroup;
use modules\exam\models\Exam;
use modules\transfer\behaviors\FileBehavior;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\StatementHelper;
use Mpdf\Tag\Tr;
use olympic\models\auth\Profiles;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%statement_transfer}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property string  $message
 * @property integer $created_at;
 * @property integer $semester;
 * @property integer $updated_at;
 * @property integer $count_pages
 * @property integer $course
 * @property integer $finance
 * @property integer $edu_count
 * @property integer $cg_id
 * @property integer $faculty_id
 * @property integer $is_protocol
 *
 **/

class StatementTransfer extends ActiveRecord
{
    const DRAFT = 0;
    const MESSAGE = 2;

    public static function tableName()
    {
        return '{{%statement_transfer}}';
    }

    public function rules()
    {
        return [
            ['message','required', 'on'=> self::MESSAGE]
        ];
    }


    public function behaviors()
    {
        return [TimestampBehavior::class, FileBehavior::class];
    }

    public static  function create($user_id,  $eduCount, $facultyId, $cgId = null, $finance = null,  $semester = null, $course=null) {
        $statement =  new static();
        $statement->user_id = $user_id;
        $statement->course = $course;
        $statement->edu_count = $eduCount;
        $statement->semester = $semester;
        $statement->cg_id = $cgId;
        $statement->faculty_id = $facultyId;
        $statement->finance = $finance;
        $statement->status = self::DRAFT;
        return $statement;
    }

    public function setCountPages($countPages) {
        $this->count_pages = $countPages;
    }

    public function setIsProtocol($status) {
        $this->is_protocol = $status;
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

    public function getTypeFinance() {
        return DictCompetitiveGroupHelper::financingTypeName($this->finance);
    }

    public function getProfileUser() {
        return $this->hasOne(Profiles::class, ['user_id' => 'user_id']);
    }

    public function getCg() {
        return $this->hasOne(DictCompetitiveGroup::class, ['id' => 'cg_id']);
    }

    public function getDictClass() {
        return $this->hasOne(DictClass::class, ['id' => 'course']);
    }

    public function getCurrentEducation() {
        return $this->hasOne(CurrentEducation::class, ['user_id' => 'user_id']);
    }

    public function getDocumentPacket($type){
        return PacketDocumentUser::findOne(['user_id' => $this->user_id,'packet_document'=>$type]);
    }

    public function getTransferMpgu() {
        return $this->hasOne(TransferMpgu::class, ['user_id' => 'user_id']);
    }

    public function getEduCount() {
        return (new CurrentEducation())->listEdu()[$this->edu_count];
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

    public function isContract() {
        return $this->finance  == DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT;
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

    public function getPassExam() {
        return $this->hasOne(PassExam::class, ['statement_id' => 'id']);
    }

    public function getNumberStatement()
    {
        return $this->user_id.'-'.$this->transferMpgu->type.'-'.date("Y");
    }

    public function getStatementAgreement()
    {
        return $this->hasOne( StatementAgreementContractTransferCg::className(), ['statement_transfer_id'=> 'id']);
    }

    public function attributeLabels()
    {
        return [
            'edu_count' => "Образование",
            'course' => 'Курс',
            'finance' => 'Вид финансирования',
            'success_exam' => 'Успешность сдачи экзамена',
            'semester' => 'Семестр',
            'cg_id' => 'Конкурсная группа',
            'user_id'=> "Студент",
            'created_at' => "Дата создания"
        ];
    }

}