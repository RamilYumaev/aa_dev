<?php


namespace olympic\forms\dictionary;


use olympic\models\dictionary\DictSpecialTypeOlimpic;
use yii\base\Model;

class DictSpecialTypeOlimpicForm extends Model
{
    public $name;

    function __construct(DictSpecialTypeOlimpic $specialTypeOlimpic = null, $config = [])
    {
        if ($specialTypeOlimpic) {
            $this->name = $specialTypeOlimpic->name;
        }
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