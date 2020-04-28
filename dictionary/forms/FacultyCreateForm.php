<?php

namespace dictionary\forms;

use dictionary\models\Faculty;
use yii\base\Model;

class FacultyCreateForm extends Model
{
    public $full_name, $filial, $short, $genitive_name;

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
            [['full_name', 'short',  'genitive_name'], 'required'],
            ['filial', 'integer'],
            ['full_name', 'unique', 'targetClass' => Faculty::class, 'message' => 'Такое наименование существует'],
            ['short', 'unique', 'targetClass' => Faculty::class, 'message' => 'Такое краткое наименование существует'],
            [['full_name', 'genitive_name'], 'string'],
            [['short'], 'string', 'max' => 10],
            [['short'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/u'],
        ];
    }

    public function attributeLabels(): array
    {
        return Faculty::labels();
    }

}