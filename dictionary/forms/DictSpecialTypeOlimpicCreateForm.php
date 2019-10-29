<?php


namespace dictionary\forms;


use dictionary\models\DictSpecialTypeOlimpic;
use yii\base\Model;

class DictSpecialTypeOlimpicCreateForm extends Model
{
    public $name;

    function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            ['name', 'unique', 'targetClass' => DictSpecialTypeOlimpic::class, 'message' => 'Такой элемент уже есть в справочнике!'],
        ];
    }

    public function attributeLabels(): array
    {
        return DictSpecialTypeOlimpic::labels();
    }

}