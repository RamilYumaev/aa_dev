<?php

namespace modules\entrant\models;
use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\DictOrganizationsHelper;
use modules\dictionary\models\DictOrganizations;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\forms\AgreementForm;
use modules\entrant\helpers\AgreementHelper;
use modules\entrant\helpers\DateFormatHelper;
use modules\entrant\models\queries\AgreementQuery;
use olympic\models\auth\Profiles;

/**
 * This is the model class for table "{{%agreement}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $organization_id
 * @property integer $work_organization_id
 * @property string  $date
 * @property string  $message
 * @property string  $status_id
 * @property string  $number
 * @property string  $year
 **/

class Agreement extends YiiActiveRecordAndModeration
{

    public static function tableName()
    {
        return '{{%agreement}}';
    }

    public function behaviors()
    {
        return [
            'moderation' => [
            'class'=> ModerationBehavior::class,
            'attributes'=>['organization_id', 'work_organization_id', 'number', 'date', 'year'],
        ],FileBehavior::class];
    }

    public static  function create(AgreementForm $form) {
        $address =  new static();
        $address->data($form);
        return $address;
    }

    public function data(AgreementForm $form)
    {
        $this->date = DateFormatHelper::formatRecord($form->date);
        $this->year = $form->year;
        $this->number = $form->number;
        $this->user_id = $form->user_id;
    }

    public function addOrganization($organization, $work) {
        $this->organization_id = $organization;
        $this->work_organization_id = $work;
    }
    public function attributeLabels()
    {
        return [
            'organization_id' => "Организация",
            'date' => 'Дата договора',
            'number'=> 'Номер договора',
            'year' =>   'Год',
            'user_id'=> "Абитуриент",
            'message'=> "Сообщение об ошибке",
            'status_id' => 'Статус'
        ];
    }

    public function titleModeration(): string
    {
          return  'Договоры(целевое обучение)';
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }


    public function setStatus($status) {
        $this->status_id = $status;
    }

    public function getValue($property){
        if ($property == "date") {
            return DateFormatHelper::formatView($this->$property);
       }
        return $this->$property;
    }

    protected function getProperty($property){
        return $this->getAttributeLabel($property).": ".$this->getValue($property);
    }

    public function getDocumentFull(){
        $string = "";
        foreach ($this->getAttributes(null,['user_id', 'id', 'work_organization_id', 'organization_id']) as  $key => $value) {
            if($value) {
                $string .= $this->getProperty($key)." ";
            }
        }
        return $string;
    }

    public function getOrganization() {
        return $this->hasOne(DictOrganizations::class, ['id' =>'organization_id']);
    }

    public function getOrganizationWork() {
        return $this->hasOne(DictOrganizations::class, ['id' =>'work_organization_id']);
    }

    public function getStatusName() {
        return  AgreementHelper::statusName($this->status_id);
    }

    public function getFullOrganization()
    {
        return  $this->organization->stringFull.' Регион: '.$this->organization->region->name;
    }

    public function getFullOrganizationWork()
    {
        return  $this->organizationWork->stringFull.' Регион: '.$this->organizationWork->region->name;
    }


    public function getProfile() {
        return $this->hasOne(Profiles::class, ['user_id' =>'user_id']);
    }

    public function getStatement() {
        return $this->hasMany(Statement::class, ['user_id' =>'user_id'])->where(['special_right'=> DictCompetitiveGroupHelper::TARGET_PLACE]);
    }

    public function moderationAttributes($value): array
    {
        return [
            'work_organization_id' =>  DictOrganizationsHelper::organizationName($value),
            'organization_id' => DictOrganizationsHelper::organizationName($value),
            'date' => DateFormatHelper::formatView($value),
            'number'=> $value,
            'year' =>  $value,
        ];
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }

    public function isStatusNew() {
       return  $this->status_id == AgreementHelper::STATUS_NEW;
    }


    public function countStatusFiles($status) {
        return $this->getFiles()->andWhere(['status'=>$status])->count();
    }

    public static function find()
    {
        return new AgreementQuery(static::class);
    }
}