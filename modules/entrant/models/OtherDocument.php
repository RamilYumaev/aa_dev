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
use modules\superservice\components\data\DocumentTypeList;
use modules\superservice\components\data\DocumentTypeVersionList;
use modules\superservice\forms\DocumentsFields;
use yii\base\DynamicModel;
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
 * @property string $other_data
 * @property integer $type_document
 * @property integer $version_document
 * @property integer $reception_quota
 *
**/

class OtherDocument extends YiiActiveRecordAndModeration
{
    public function behaviors()
    {
        return ['moderation' => [
            'class' => ModerationBehavior::class,
            'attributes' => [ 'type', 'series', 'number', 'date', 'authority', 'main_status',
                'other_data',
                'reception_quota',
                'type_document',
                'version_document'],
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
        $this->reception_quota = $form->reception_quota;
    }

    public function versionData(OtherDocumentForm $form)
    {
        $this->type_document = $form->type_document;
        $this->version_document = $form->version_document;
    }

    public function otherData($data)
    {
        $this->other_data = json_encode($data);
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
        elseif ($property == "reception_quota")  {
            return $this->$property && key_exists($this->$property,  $this->getReceptionList()) ? $this->getReceptionList()[$this->$property] : '';
        }
        elseif ($property == "other_data") {
            return json_decode($this->$property) === false ? '': (new DocumentsFields())->data(json_decode($this->$property, true));
        }
        elseif ($property == "type_document")  {
            return $this->$property && key_exists($this->$property,  $this->getTypeDocumentList()) ? $this->getTypeDocumentList()[$this->$property]['Name'] : '';
        }
        elseif ($property == "version_document")  {
            return $this->$property && key_exists($this->$property, $this->getTypeVersionDocumentList()) ? $this->getTypeVersionDocumentList()[$this->$property]['DocVersion']  : '';
        }else {
            return $this->$property;
        }
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
            'type'=>'Наименование',
            'series'=> "Серия",
            'number'=> "Номер",
            'authority' => "Кем выдан",
            'amount' => "Количество",
            'date' => "Дата выдачи",
            'exemption_id'=> "Категория льготы",
            'type_document'=>'Тип документа',
            'version_document' => 'Версия документа',
            'other_data' => 'Дополнительные данные версии документа',
            'reception_quota' => 'Прием в соответствии'
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

    public function getReceptionList() {
        return [
            1 => 'с подпунктом “а” пунктом 2',
            2 => 'с подпунктом “б” пунктом 2'
        ];
    }

    public function getTypeDocumentList() {
        $document = new DocumentTypeList();
        return $document->getArray()->index('Id');
    }

    public function getTypeVersionDocumentList() {
        $document = new DocumentTypeVersionList();
        return $document->getArray()
            ->getArrayWithProperties($document->getProperties(), true)->index('Id');
    }

    public function moderationAttributes($value): array
    {
        return [
            'type' => is_int($value) && key_exists($value, $this->getTypeList()) ? $this->getTypeList()[$value]: $value,
            'series' => $value,
            'number'=> $value,
            'date'=> DateFormatHelper::formatView($value),
            'authority'=> $value,
            'type_document'=> $value && key_exists($value,  $this->getTypeDocumentList()) ? $this->getTypeDocumentList()[$value]['Name'] : $value,
            'version_document' => $value && key_exists($value,  $this->getTypeVersionDocumentList()) ? $this->getTypeVersionDocumentList()[$value]['DocVersion'] : $value,
            'other_data' => json_decode($value) === false ? '': (new DocumentsFields())->data(json_decode($value, true)),
            'reception_quota' =>  is_int($value) && key_exists($value, $this->getReceptionList()) ? $this->getReceptionList()[$value]: $value,
        ];
    }
}