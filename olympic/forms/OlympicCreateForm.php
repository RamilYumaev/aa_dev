<?php


namespace olympic\forms;


use dictionary\helpers\DictFacultyHelper;
use dictionary\models\DictChairmans;
use dictionary\helpers\DictChairmansHelper;
use olympic\helpers\OlympicHelper;
use olympic\models\Olympic;
use yii\base\Model;

class OlympicCreateForm extends Model
{
    public $name,
           $status;

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
            [['name'], 'required'],
            ['name', 'unique', 'targetClass' => Olympic::class, 'message' => 'Такое название олимпиады уже есть'],
            [['status',], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return Olympic::labels();
    }

}