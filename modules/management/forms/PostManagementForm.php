<?php

namespace modules\management\forms;
use modules\management\models\PostManagement;
use yii\base\Model;

class PostManagementForm extends Model
{
    public $name, $name_short, $is_director;
    private $_postManagement;

    public function __construct(PostManagement $postManagement = null, $config = [])
    {
        if ($postManagement) {
            $this->setAttributes($postManagement->getAttributes(), false);
            $this->_postManagement = $postManagement;
        }
        parent::__construct($config);
    }
    

    public function defaultRules()
    {
        return [
            [['name', 'name_short'], 'required'],
            [['name', 'name_short'], 'string', 'max' => 255],
            [['is_director'], 'boolean']
        ];
    }

    public function uniqueRules()
    {
        $arrayUnique = [['name'], 'unique', 'targetClass' => PostManagement::class];
        if ($this->_postManagement) {
            return array_merge($arrayUnique, ['filter' => ['<>', 'id', $this->_postManagement->id]]);
        }

        return $arrayUnique;
    }

    public function rules()
    {
        return array_merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function attributeLabels()
    {
        return (new PostManagement())->attributeLabels();
    }
}