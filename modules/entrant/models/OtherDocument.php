<?php


namespace modules\entrant\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\dictionary\models\DictIncomingDocumentType;
use modules\entrant\behaviors\CseDeleteBehavior;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\forms\AddressForm;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\forms\PassportDataForm;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\DateFormatHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\helpers\OtherDocumentHelper;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%other_document}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property integer $type_note
 * @property integer $note
 * @property string $series
 * @property string $number
 * @property  integer $without
 * @property string $date
 * @property string $authority
 * @property integer $amount
 * @property integer $exemption_id
 *
**/

class OtherDocument extends YiiActiveRecordAndModeration
{
    public function behaviors()
    {
        return ['moderation' => [
            'class' => ModerationBehavior::class,
            'attributes' => [ 'type', 'series', 'number', 'date', 'authority', 'main_status'],
            'attributesNoEncode' => ['series', 'number'],
        ],
            FileBehavior::class,
            CseDeleteBehavior::class,
            ];
    }


    public static  function create(OtherDocumentForm $form) {
        $otherDocument =  new static();
        $otherDocument->data($form);
        return $otherDocument;
    }

    public function data(OtherDocumentForm $form)
    {
        $this->type = $form->type;
        $this->amount = $this->type == DictIncomingDocumentTypeHelper::ID_PHOTO ? $form->amount : 1;
        $this->series = $form->series;
        $this->authority = $form->authority;
        $this->number = $form->number;
        $this->date = $form->date ? DateFormatHelper::formatRecord($form->date) : null;
        $this->exemption_id = $form->exemption_id;
        $this->without = $form->without;
        $this->user_id = $form->user_id;
    }

    public static  function createNote($typeNote, $type,  $user_id, $note) {
        $otherDocument =  new static();
        $otherDocument->dataNote($typeNote,  $type,  $user_id, $note);
        return $otherDocument;
    }

    public function dataNote($typeNote,  $type,  $user_id, $note)
    {
        $this->type_note = $typeNote;
        $this->type = $type;
        $this->user_id = $user_id;
        $this->note = $note;
    }


    public static function tableName()
    {
        return "{{%other_document}}";
    }

    public function titleModeration(): string
    {
        return "Прочие документы";
    }

    public function getDictIncomingDocumentType()
    {
        return $this->hasOne(DictIncomingDocumentType::class, ['id' => 'type']);
    }


    public function getTypeName()
    {
        return $this->dictIncomingDocumentType->name;
    }

    public function getValue($property){
        if ($property == "date") {
            return DateFormatHelper::formatView($this->$property);
        }
        return $this->$property;
    }

    public function getExemption(){
       return DictDefaultHelper::categoryExemptionName($this->exemption_id);
    }


    protected function getProperty($property){
        return $this->getAttributeLabel($property).": ".$this->getValue($property);
    }

    public function getOtherDocumentFull(){
        $string = "";
        foreach ($this->getAttributes(null,['user_id', 'type', 'note', 'type_note','id', 'without','exemption_id']) as  $key => $value) {
            if($value) {
                $string .= $this->getProperty($key)." ";
            }
        }
        return $string;
    }

    public function getOtherDocumentFullStatement(){
        $string = "";
        foreach ($this->getAttributes(null,['user_id', 'type', 'note', 'type_note','id','exemption_id', 'amount']) as  $key => $value) {
            if($value) {
                $string .= $this->getProperty($key)." ";
            }
        }
        return $string;
    }


    public function getPreemptiveRights() {
        return $this->hasMany(PreemptiveRight::class, ['other_id'=> 'id']);
    }

    public function preemptiveRightsTypeOne($type) {
        return $this->hasOne(PreemptiveRight::class, ['other_id'=> 'id'])->andWhere(['type_id' => $type])->one();
    }

    public function getNoteOrTypeNote() {
        return $this->type_note ? OtherDocumentHelper::translationList()[$this->type_note] : $this->note;
    }

    public function isPhoto() {
        return $this->type == DictIncomingDocumentTypeHelper::ID_PHOTO;
    }


    public function attributeLabels()
    {
        return [
            'type'=>'Тип документа',
            'series'=> "Серия",
            'number'=> "Номер",
            'authority' => "Кем выдан",
            'amount' => "Количество",
            'date' => "Дата выдачи",
            'exemption_id'=> "Категория льготы",
        ];
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function getAisReturnData() {
        return $this->hasOne(AisReturnData::class, ['record_id_sdo'=> 'id'])->where(['model'=> self::class]);
    }

    public function getUserIndividualAchievements() {
        return $this->hasOne(UserIndividualAchievements::class, ['document_id'=> 'id']);
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }

    public function getTypeList() {
        return DictIncomingDocumentType::find()->select('name')->indexBy('id')->column();
    }

    public function moderationAttributes($value): array
    {
        return [
            'type' => is_int($value) && key_exists($value, $this->getTypeList()) ? $this->getTypeList()[$value]: $value,
            'series' => $value,
            'number'=> $value,
            'date'=> DateFormatHelper::formatView($value),
            'authority'=> $value,
        ];
    }
}