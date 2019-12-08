<?php


namespace olympic\forms;


use common\auth\helpers\UserHelper;
use common\auth\models\User;
use dictionary\helpers\DictFacultyHelper;
use dictionary\models\DictChairmans;
use dictionary\helpers\DictChairmansHelper;
use olympic\helpers\auth\ProfileHelper;
use olympic\helpers\OlympicHelper;
use olympic\models\Olympic;
use yii\base\Model;
use yii\debug\models\search\Profile;

class OlympicCreateForm extends Model
{
    public $name,
        $status,
        $managerId;

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
            [['status', 'managerId'], 'integer'],
            ['managerId', 'in', 'range' => UserHelper::getAllUserId()],
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


    public function statusList()
    {
        return OlympicHelper::statusList();
    }


}