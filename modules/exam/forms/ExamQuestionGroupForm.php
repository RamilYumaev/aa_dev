<?php
namespace modules\exam\forms;

use modules\dictionary\models\JobEntrant;
use modules\exam\models\ExamQuestionGroup;
use modules\exam\models\ExamTest;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ExamQuestionGroupForm extends Model
{
    public $discipline_id, $name;
    public $jobEntrant;
    private $_group;

    public function __construct(JobEntrant $jobEntrant, ExamQuestionGroup $group =null, $config = [])
    {
        if($group){
            $this->setAttributes($group->getAttributes(), false);
            $this->_group = $group;
        }
        $this->jobEntrant = $jobEntrant;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function defaultRules()
    {
        return [
            [['name', 'discipline_id'], 'required'],
            [['discipline_id'], 'integer'],
            [['name'], 'string', 'max'=>255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        $arrayUnique = [['name'], 'unique', 'targetClass' => ExamQuestionGroup::class,
            'targetAttribute' => ['discipline_id', 'name'], 'message'=>'Вы уже добавили'];
        if ($this->_group) {
            return ArrayHelper::merge($arrayUnique,['filter' => ['<>', 'id', $this->_group->id]]);
        }
        return $arrayUnique;
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return ArrayHelper::merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new ExamQuestionGroup())->attributeLabels();
    }

}