<?php


namespace dod\forms;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use dod\models\Dod;
use yii\base\Model;

class DodEditForm extends Model
{
    public $name, $type, $address, $aud_number, $description, $faculty_id, $edu_level, $slug, $photo_report;
    public $_dod;

    public function __construct(Dod $dod, $config = [])
    {
        $this->name = $dod->name;
        $this->type = $dod->type;
        $this->address = $dod->address;
        $this->aud_number = $dod->aud_number;
        $this->description = $dod->description;
        $this->faculty_id = $dod->faculty_id;
        $this->edu_level = $dod->edu_level;
        $this->photo_report = $dod->photo_report;
        $this->slug = $dod->slug;
        $this->_dod = $dod;
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
            [['slug', 'photo_report'], 'string', 'max' => 255],
            ['name', 'unique', 'targetClass' => Dod::class, 'filter' => ['<>', 'id', $this->_dod->id], 'message' => 'Такое олимпиады уже есть'],
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