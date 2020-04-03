<?php


namespace modules\entrant\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictSchoolsHelper;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\entrant\forms\DocumentEducationForm;
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\DateFormatHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\interfaces\models\DataModel;
use modules\entrant\models\queries\DocumentEducationQuery;

/**
 * This is the model class for table "{{%document_education}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $school_id
 * @property integer $type
 * @property string $series
 * @property string $number
 * @property string $date
 * @property string $year
 * @property string $original
 * @property string $patronymic
 * @property string $surname
 * @property string $name
 *
**/

class DocumentEducation extends YiiActiveRecordAndModeration implements DataModel
{
    public function behaviors()
    {
        return ['moderation' => [
            'class'=> ModerationBehavior::class,
            'attributes'=>['school_id','type', 'series', 'number', 'date', 'year',
                'patronymic', 'surname', 'name', 'original', ]
        ]];
    }

    public static  function create(DocumentEducationForm $form, $school_id) {
        $address =  new static();
        $address->data($form, $school_id);
        return $address;
    }

    public function data(DocumentEducationForm $form, $school_id)
    {
        $this->school_id = $school_id;
        $this->type = $form->type;
        $this->series = $form->series;
        $this->number = $form->number;
        $this->date = DateFormatHelper::formatRecord($form->date);
        $this->year = $form->year;
        $this->original = $form->original;
        $this->surname = !$form->fio ? $form->surname : null;
        $this->patronymic = !$form->fio ? $form->patronymic : null;
        $this->name = !$form->fio ? $form->name : null;
        $this->user_id = $form->user_id;
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

    public function getTypeName() {
        return DictIncomingDocumentTypeHelper::typeName(DictIncomingDocumentTypeHelper::TYPE_EDUCATION, $this->type);
    }

    public function getSchoolName() {
        return  DictSchoolsHelper::schoolName($this->school_id);
    }

    public function getOriginal() {
        return   DictDefaultHelper::name($this->original);
    }


    public static function tableName()
    {
        return "{{%document_education}}";
    }

    public function titleModeration(): string
    {
        return "Документ об образовании";
    }

    public function moderationAttributes($value): array
    {
        return [
            'school_id' => DictSchoolsHelper::schoolName($value),
            'type' => DictIncomingDocumentTypeHelper::typeName(DictIncomingDocumentTypeHelper::TYPE_EDUCATION, $value),
            'series' => $value,
            'number'=> $value,
            'date'=> DateFormatHelper::formatView($value),
            'year'=> $value,
            'original'=> DictDefaultHelper::name($value)
            ];
    }

    public function attributeLabels()
    {
        return [
            'school_id' => 'Учебная организация',
            'type'=>'Тип документа',
            'series'=>'Серия',
            'number'=>'Номер',
            'date'=>'От',
            'year'=>'Год окончания',
            'original' => 'Оригинал?',
            'patronymic' => 'Отчество',
            'surname' => "Фамилия",
            'name' => 'Имя',
        ];
    }

    public static function find(): DocumentEducationQuery
    {
        return new DocumentEducationQuery(static::class);
    }

    public function isDataNoEmpty(): bool
    {
        $arrayNoRequired = ['user_id', 'original','patronymic'];
        if(!$this->name && !$this->surname)
        {
            array_push($arrayNoRequired, 'surname','name');
        }
        return BlockRedGreenHelper::dataNoEmpty($this->getAttributes(null, $arrayNoRequired));
    }
}