<?php


namespace olympic\forms;

use olympic\helpers\OlympicHelper;
use olympic\models\Olympic;
use yii\base\Model;

class OlympicEditForm extends Model
{
    public $name,
        $status,
        $_olympic;

    public function __construct(Olympic $olympic, $config = [])
    {
        $this->name = $olympic->name;
        $this->status = $olympic->status;
        $this->_olympic= $olympic;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'unique', 'targetClass' => Olympic::class, 'filter' => ['<>', 'id', $this->_olympic->id], 'message' => 'Такое название олимпиады уже есть'],
            [['status'], 'integer'],
            ['status', 'in', 'range' => OlympicHelper::statusListValid(), 'allowArray' => true],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return Olympic::labels();
    }

    public  function statusList() {
        return OlympicHelper::statusList();
    }
}