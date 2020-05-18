<?php


namespace modules\entrant\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictSchoolsHelper;
use dictionary\models\DictSchools;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\entrant\behaviors\FileBehavior;
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
                'patronymic', 'surname', 'name' ]
        ], FileBehavior::class];
    }

    public static  function create(DocumentEducationForm $form, $school_id) {
        $doc =  new static();
        $doc->data($form, $school_id);
        return $doc;
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

    public function getDocumentFull(){
        $string = "";
        foreach ($this->getAttributes(null,['user_id', 'type', 'id', 'school_id','original']) as  $key => $value) {
            if($value) {
                $string .= $this->getProperty($key)." ";
            }
        }
        return $string;
    }

    public function getSchool() {
        return $this->hasOne(DictSchools::class,['id'=>'school_id']);
    }


    public function getSchoolName() {
        return  $this->school->name;
    }

    public function getOriginal() {
        return  DictDefaultHelper::name($this->original);
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
            'original'=> DictDefaultHelper::name($value),
            'patronymic' => $value,
            'surname' => $value,
            'name' => $value
            ];
    }

    public function dataArray()
    {
        return [
            'school_id' => $this->schoolName,
            'type'=> $this->typeName,
            'schoolCountyRegion' => $this->school->countryRegion,
            'series'=>$this->series,
            'number'=>$this->number,
            'date'=>$this->date,
            'year'=>$this->year,
            'patronymic' => $this->patronymic,
            'surname' => $this->surname,
            'name' => $this->name,
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

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }
}