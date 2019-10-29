<?php


namespace dictionary\forms;


use dictionary\models\DictSpecialTypeOlimpic;
use yii\base\Model;

class DictSpecialTypeOlimpicEditForm extends Model
{
    public $name, $_specialTypeOlimpic;

    function __construct(DictSpecialTypeOlimpic $specialTypeOlimpic, $config = [])
    {
        $this->name = $specialTypeOlimpic->name;
        $this->_specialTypeOlimpic = $specialTypeOlimpic;

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
            ['name', 'unique', 'targetClass' => DictSpecialTypeOlimpic::class, 'filter' => ['<>', 'id', $this->_specialTypeOlimpic->id], 'message' => 'Такой элемент уже есть в справочнике!'],
        ];
    }

    public function attributeLabels(): array
    {
        return DictSpecialTypeOlimpic::labels();
    }

}