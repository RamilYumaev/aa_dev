<?php
namespace modules\exam\forms;

use modules\dictionary\models\JobEntrant;
use modules\exam\models\ExamQuestionGroup;
use modules\exam\models\ExamTest;
use modules\exam\models\ExamViolation;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ExamViolationForm extends Model
{
    public $exam_statement_id, $message;
    private $_violation;

    public function __construct(ExamViolation $violation =null, $config = [])
    {
        if($violation){
            $this->setAttributes($violation->getAttributes(), false);
            $this->_violation = $violation;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['exam_statement_id', 'message'], 'required'],
            [['exam_statement_id'], 'integer'],
            [['message'], 'string', 'max'=>255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new ExamViolation())->attributeLabels();
    }

}