<?php

namespace dictionary\forms;

use dictionary\models\Faculty;
use yii\base\Model;

class FacultyEditForm extends Model
{
    public $full_name;
    public $_faculty;
    public $filial;
    public  $short, $genitive_name;

    /**
     * {@inheritdoc}
     */
    public function __construct(Faculty $faculty, $config = [])
    {
        $this->full_name = $faculty->full_name;
        $this->filial = $faculty->filial;
        $this->_faculty = $faculty;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['full_name', 'short',  'genitive_name'], 'required'],
            ['filial', 'integer'],
            [['full_name', 'genitive_name'], 'string'],
            [['short'], 'string', 'max' => 10],
            [['short'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/u'],
            ['full_name', 'unique', 'targetClass' => Faculty::class, 'filter' => ['<>', 'id', $this->_faculty->id],
                'message' => 'Такое наименование существует'],
            ['short', 'unique', 'targetClass' => Faculty::class, 'filter' => ['<>', 'id', $this->_faculty->id],
                'message' => 'Такое краткое наименование существует'],

        ];
    }

    public function attributeLabels(): array
    {
        return Faculty::labels();
    }

}