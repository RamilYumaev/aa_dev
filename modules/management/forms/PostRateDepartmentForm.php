<?php

namespace modules\management\forms;
use modules\management\models\PostManagement;
use modules\management\models\PostRateDepartment;
use modules\management\models\queries\DictDepartmnetQuery;
use yii\base\Model;

class PostRateDepartmentForm extends Model
{
    public $dict_department_id, $post_management_id, $rate, $taskList;
    private $_postRateDepartment;

    public function __construct(PostRateDepartment $postRateDepartment = null, $config = [])
    {
        if ($postRateDepartment) {
            $this->setAttributes($postRateDepartment->getAttributes(), false);
            $this->taskList = $postRateDepartment->getManagementTasks()->select(['dict_task_id'])->column();
            $this->_postRateDepartment = $postRateDepartment;
        } else {
            $this->taskList = [];

        }
        parent::__construct($config);
    }
    

    public function defaultRules()
    {
        return [
            [['post_management_id', 'rate', 'taskList'], 'required'],
            [['post_management_id', 'rate', 'dict_department_id'], 'integer'],
            [['taskList'], 'safe'],
        ];
    }

    public function uniqueRules()
    {
        $arrayUnique = [['post_management_id'], 'unique', 'targetClass' => PostRateDepartment::class, 'targetAttribute' => ['post_management_id', 'rate', 'dict_department_id']];
        if ($this->_postRateDepartment) {
            return array_merge($arrayUnique, ['filter' => ['<>', 'id', $this->_postRateDepartment->id]]);
        }

        return $arrayUnique;
    }

    public function rules()
    {
        return array_merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function attributeLabels()
    {
        return (new PostRateDepartment())->attributeLabels()+['taskList'=> "Функции"];
    }
}