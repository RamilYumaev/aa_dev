<?php


namespace modules\entrant\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use DateTime;
use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\dictionary\models\DictIncomingDocumentType;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\forms\AddressForm;
use modules\entrant\forms\PassportDataForm;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\DateFormatHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use yii\base\InvalidConfigException;

/**
 * This is the model class for table "{{%passport_data}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $nationality
 * @property integer $type
 * @property string $series
 * @property string $number
 * @property string $date_of_birth
 * @property string $place_of_birth
 * @property string $date_of_issue
 * @property string $authority
 * @property string $division_code
 * @property integer $main_status
 *
 **/
class PassportData extends YiiActiveRecordAndModeration
{
    public function behaviors()
    {
        return ['moderation' => [
            'class' => ModerationBehavior::class,
            'attributes' => ['nationality', 'type', 'series', 'number',
                'date_of_birth',
                'place_of_birth', 'date_of_issue', 'authority',
                'division_code', 'main_status'],
            'attributesNoEncode' => ['series', 'number'],
        ], FileBehavior::class, \modules\transfer\behaviors\FileBehavior::class];
    }

    public static function create(PassportDataForm $form, $status)
    {
        $address = new static();
        $address->data($form, $status);
        return $address;
    }

    public function data(PassportDataForm $form, $status)
    {
        $this->nationality = $form->nationality;
        $this->type = $form->type;
        $this->series = $form->series;
        $this->number = $form->number;
        $this->date_of_birth = DateFormatHelper::formatRecord($form->date_of_birth);
        $this->place_of_birth = mb_strtoupper($form->place_of_birth);
        $this->date_of_issue = DateFormatHelper::formatRecord($form->date_of_issue);
        $this->authority = mb_strtoupper($form->authority);
        $this->main_status = $status;
        $this->division_code = $form->division_code;
        $this->user_id = $form->user_id;
    }

    public function getValue($property)
    {
        if ($property == "date_of_birth" || $property == "date_of_issue") {
            return DateFormatHelper::formatView($this->$property);
        }
        return $this->$property;
    }

    protected function getProperty($property)
    {
        return $this->getAttributeLabel($property) . ": " . $this->getValue($property);
    }

    public function getPassportFull()
    {
        $string = "";
        foreach ($this->getAttributes(null, ['user_id', 'type', 'nationality', 'id', 'main_status']) as $key => $value) {
            if ($value) {
                $string .= $this->getProperty($key) . " ";
            }
        }
        return $string;
    }

    public static function tableName()
    {
        return "{{%passport_data}}";
    }

    public function getMainStatus()
    {
        return DictDefaultHelper::name($this->main_status);
    }

    public function titleModeration(): string
    {
        return "Паспортные данные";
    }

    public function getDictIncomingDocumentType()
    {
        return $this->hasOne(DictIncomingDocumentType::class, ['id' => 'type']);
    }


    public function getTypeName()
    {
        return $this->dictIncomingDocumentType->name;
    }


    public function getNationalityName()
    {
        return DictCountryHelper::countryName($this->nationality);
    }

    public function moderationAttributes($value): array
    {
        return [
            'nationality' => DictCountryHelper::countryName($value),
            'type' => DictIncomingDocumentTypeHelper::typeName(DictIncomingDocumentTypeHelper::TYPE_PASSPORT, $value),
            'series' => $value,
            'place_of_birth' => $value,
            'number' => $value,
            'date_of_birth' => DateFormatHelper::formatView($value),
            'date_of_issue' => DateFormatHelper::formatView($value),
            'authority' => $value,
            'division_code' => $value,
            'main_status' => DictDefaultHelper::name($value)
        ];
    }

    public function attributeLabels()
    {
        return [
            'nationality' => 'Гражданство',
            'type' => 'Тип документа',
            'series' => 'Серия',
            'number' => 'Номер',
            'date_of_birth' => 'Дата рождения',
            'place_of_birth' => 'Место рождения',
            'date_of_issue' => 'Дата выдачи',
            'authority' => 'Кем выдан',
            'division_code' => 'Код подразделения',
            'main_status' => 'Основной документ',
            'nationalityName' => 'Гражданство',
            'typeName' => "Тип документа"
        ];
    }

    public function dataArray()
    {
        return [
            'nationality' => $this->nationalityName,
            'type' => $this->typeName,
            'series' => $this->series,
            'number' => $this->number,
            'date_of_birth' => DateFormatHelper::formatView($this->date_of_birth),
            'place_of_birth' => $this->place_of_birth,
            'date_of_issue' => DateFormatHelper::formatView($this->date_of_issue),
            'authority' => $this->authority,
            'division_code' => $this->division_code,
            'age'=> $this->age()
        ];
    }

    public function age()
    {
        $datetime = new DateTime($this->date_of_birth);
        $interval = $datetime->diff(new DateTime(date("Y-m-d")));
        return $interval->format("%Y");
    }

    public function getFiles()
    {
        return $this->hasMany(File::class, ['record_id' => 'id'])->where(['model' => self::class]);
    }

    public function countFiles()
    {
        return $this->getFiles()->count();
    }

    public function getFilesTransfer()
    {
        return $this->hasMany(\modules\transfer\models\File::class, ['record_id' => 'id'])->where(['model' => self::class]);
    }

    public function countTransfer()
    {
        return $this->getFilesTransfer()->count();
    }

}