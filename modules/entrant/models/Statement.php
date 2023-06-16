<?php
namespace modules\entrant\models;


use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\queries\StatementQuery;
use olympic\models\auth\Profiles;
use yii\behaviors\TimestampBehavior;
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
 * @property integer $form_category
 * @property integer $finance
 * @property string  $message
 * @property integer $created_at;
 * @property integer $updated_at;
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

    public function behaviors()
    {
        return [TimestampBehavior::class, FileBehavior::class];
    }

    public static  function create($user_id, $faculty_id, $speciality_id, $special_right, $edu_level,
                                   $counter,
                                   $formCategory, $finance = 0) {
        $statement =  new static();
        $statement->user_id = $user_id;
        $statement->faculty_id = $faculty_id;
        $statement->speciality_id = $speciality_id;
        $statement->edu_level = $edu_level;
        $statement->special_right = $special_right;
        $statement->counter = $counter;
        $statement->form_category = $formCategory;
        $statement->status = self::DRAFT;
        $statement->finance = $finance;
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

    public function getProfileUser() {
        return $this->hasOne(Profiles::class, ['user_id' => 'user_id']);
    }

    public function getStatementRejection() {
        return $this->hasOne(StatementRejection::class, ['statement_id' => 'id']);
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
        return $this->count_pages &&  $this->countFiles() >= 1;
    }

    public function statementCgConsent() {
        /* @var  $cg StatementCg */
        foreach ($this->statementCg as $cg) {
            if($cg->getStatementConsentFiles()) {
                return true; break;
            }
        }
        return false;
    }

    public function statementContractCg() {
        /* @var  $cg StatementCg */
        foreach ($this->statementCg as $cg) {
            if($cg->cg->isContractCg()) {
                return true; break;
            }
        }
        return false;
    }

    public function statementBudgetCg() {
        /* @var  $cg StatementCg */
        foreach ($this->statementCg as $cg) {
            if($cg->cg->isBudget()) {
                return true; break;
            }
        }
        return false;
    }

    public function getStatusName() {
        return  StatementHelper::statusName($this->status);
    }


    public function getSpeciality() {
        return $this->hasOne(DictSpeciality::class, ['id' => 'speciality_id']);
    }

    public function getNumberStatement()
    {
        return DictCompetitiveGroupHelper::getEduLevelsAbbreviatedShortOne($this->edu_level)."-".
            ($this->faculty->short ?? $this->faculty_id)."-".
            ($this->speciality->short ?? $this->speciality_id)."-".
            DictCompetitiveGroupHelper::getSpecialRightShortOne($this->special_right)."-".
            $this->form_category."-".
            $this->finance."-".
            $this->user_id."-".
            $this->counter;
    }

    public function getTextEmail() {
        return "Ваше заявление об участии в конкурсе №".$this->numberStatement." в ".$this->faculty->full_name. " принято";
    }

    public function getEduLevel()
    {
        return DictCompetitiveGroupHelper::eduLevelName($this->edu_level);
    }

    public function getEduFinance()
    {
        return DictCompetitiveGroupHelper::financingTypeName($this->finance);
    }

    public function getEduForm()
    {
        return $this->form_category == DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_1 ?
            'о или о-з' : 'з';
    }

    public function getSpecialRight()
    {
        return  DictCompetitiveGroupHelper::specialRightName($this->special_right);
    }

    public function isSpecialRightStatement()
    {
        return  $this->special_right==DictCompetitiveGroupHelper::SPECIAL_RIGHT ||
            $this->special_right==DictCompetitiveGroupHelper::TARGET_PLACE
            || $this->special_right==DictCompetitiveGroupHelper::SPECIAL_QUOTA;
    }

    public function isSpecialRightTarget()
    {
        return $this->special_right==DictCompetitiveGroupHelper::TARGET_PLACE;
    }

    public function isSpecialQuota()
    {
        return $this->special_right==DictCompetitiveGroupHelper::SPECIAL_QUOTA;
    }

    public function columnIdCg(){
        return $this->getStatementCg()->select(['cg_id'])->column();
    }

    public function attributeLabels()
    {
        return ['faculty_id' => "Факультет",
            'speciality_id' => "Направление подготовки",
            'edu_level' => "Уровень образования",
            'special_right' => "Основание приема",
            'finance' => "Вид финансирования",
            'form_category' => "Форма обучения",
            'user_id'=> "Абитуриент",
            'created_at' => "Дата создания"
        ];
    }
}