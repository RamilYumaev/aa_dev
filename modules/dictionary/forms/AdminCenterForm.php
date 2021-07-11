<?php
namespace modules\dictionary\forms;

use modules\dictionary\models\AdminCenter;
use yii\base\Model;

class AdminCenterForm extends Model
{
    public $job_entrant_id, $category;
    private $_adminCenter;


    public function __construct(AdminCenter $adminCenter = null, $config = [])
    {
        if($adminCenter){
            $this->setAttributes($adminCenter->getAttributes(), false);
            $this->_adminCenter = $adminCenter;
        }

        parent::__construct($config);
    }

    public function uniqueRules()
    {
        $arrayUnique = [['job_entrant_id'], 'unique', 'targetClass' => AdminCenter::class];
        if ($this->_adminCenter) {
            return array_merge($arrayUnique, ['filter' => ['<>', 'id', $this->_adminCenter->id]]);
        }
        return $arrayUnique;
    }

    public function defaultRules()
    {
        return [
            [['job_entrant_id','category'], 'required'],
            [['job_entrant_id','category'], 'integer'],
        ];
    }

    public function rules()
    {
        return array_merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function attributeLabels()
    {
        return (new AdminCenter())->attributeLabels();
    }
}