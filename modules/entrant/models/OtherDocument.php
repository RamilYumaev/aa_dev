<?php


namespace modules\entrant\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\forms\AddressForm;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\forms\PassportDataForm;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\DateFormatHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use mysql_xdevapi\SqlStatementResult;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%other_document}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property string $series
 * @property string $number
 * @property string $date
 * @property string $authority
 * @property integer $amount
 * @property integer $exemption_id
 *
**/

class OtherDocument extends ActiveRecord
{
    public function behaviors()
    {
        return [FileBehavior::class];
    }


    public static  function create(OtherDocumentForm $form) {
        $otherDocument =  new static();
        $otherDocument->data($form);
        return $otherDocument;
    }

    public function data(OtherDocumentForm $form)
    {
        $this->type = $form->type;
        $this->amount = $form->amount;
        $this->series = $form->series;
        $this->authority = $form->authority;
        $this->number = $form->number;
        $this->date = $form->date ? DateFormatHelper::formatRecord($form->date) : null;
        $this->exemption_id = $form->exemption_id;
        $this->user_id = $form->user_id;
    }

    public static function tableName()
    {
        return "{{%other_document}}";
    }

    public function titleModeration(): string
    {
        return "Прочие документы";
    }

    public function getTypeName() {
        return DictIncomingDocumentTypeHelper::typeName([DictIncomingDocumentTypeHelper::TYPE_EDUCATION_PHOTO,
            DictIncomingDocumentTypeHelper::TYPE_EDUCATION_VUZ,
            DictIncomingDocumentTypeHelper::TYPE_DIPLOMA,
            DictIncomingDocumentTypeHelper::TYPE_MEDICINE,
            DictIncomingDocumentTypeHelper::TYPE_OTHER], $this->type);
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
        foreach ($this->getAttributes(null,['user_id', 'type', 'note', 'id','exemption_id']) as  $key => $value) {
            if($value) {
                $string .= $this->getProperty($key)." ";
            }
        }
        return $string;
    }


    public function getPreemptiveRights() {
        return $this->hasMany(PreemptiveRight::class, ['other_id'=> 'id']);
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

    public function countFiles() {
        return $this->getFiles()->count();
    }

}