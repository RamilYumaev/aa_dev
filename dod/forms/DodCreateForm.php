<?php


namespace dod\forms;


use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use dod\models\Dod;
use yii\base\Model;

class DodCreateForm extends Model
{
    public $name, $type, $address, $aud_number, $description, $faculty_id, $edu_level, $slug, $photo_report;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'address'], 'required'],
            [['name', 'address', 'aud_number', 'description'], 'string'],
            [['type', 'faculty_id', 'edu_level'], 'integer'],
            ['name', 'unique', 'targetClass' => Dod::class, 'message' => 'Такое название уже есть'],
            [['slug', 'photo_report'], 'string', 'max' => 255],
            [['aud_number'], 'string', 'max' => 32],
            ['edu_level', 'in', 'range' => DictCompetitiveGroupHelper::eduLevels(), 'allowArray' => true],
        ];
    }

    public function facultyList(): array
    {
        return DictFacultyHelper::facultyList();
    }

    public function eduLevelsList(): array
    {
        return DictCompetitiveGroupHelper::getEduLevels();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return Dod::labels();
    }

}