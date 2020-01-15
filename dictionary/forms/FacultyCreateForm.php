<?php

namespace dictionary\forms;

use dictionary\models\Faculty;
use yii\base\Model;

class FacultyCreateForm extends Model
{
    public $full_name, $filial;

    /**
     * {@inheritdoc}
     */
    public function __construct( $config = [])
    {
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['full_name', 'required'],
            ['filial', 'integer'],
            ['full_name', 'unique', 'targetClass' => Faculty::class, 'message' => 'Такое наименование существует'],
            ['full_name', 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return Faculty::labels();
    }

}