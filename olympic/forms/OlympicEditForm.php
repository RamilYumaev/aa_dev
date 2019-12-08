<?php


namespace olympic\forms;

use common\auth\helpers\UserHelper;
use olympic\helpers\OlympicHelper;
use olympic\models\Olympic;
use yii\base\Model;

class OlympicEditForm extends Model
{
    public $name,
        $status,
        $_olympic, $managerId;

    public function __construct(Olympic $olympic, $config = [])
    {
        $this->name = $olympic->name;
        $this->status = $olympic->status;
        $this->managerId = $olympic->managerId;
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
            [['status','managerId'], 'integer'],
            ['managerId', 'in', 'range'=> UserHelper::getAllUserId()],
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