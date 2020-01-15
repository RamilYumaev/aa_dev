<?php

namespace dictionary\forms;

use dictionary\models\Faculty;
use yii\base\Model;

class FacultyEditForm extends Model
{
    public $full_name;
    public $_faculty;
    public $filial;

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
            ['full_name', 'required'],
            ['filial', 'integer'],
            ['full_name', 'unique', 'targetClass' => Faculty::class, 'filter' => ['<>', 'id', $this->_faculty->id],
                'message' => 'Такое наименование существует'],
            ['full_name', 'string'],

        ];
    }

    public function attributeLabels(): array
    {
        return Faculty::labels();
    }

}