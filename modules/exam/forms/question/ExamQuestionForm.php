<?php


namespace modules\exam\forms\question;

use modules\dictionary\models\JobEntrant;
use modules\exam\models\ExamQuestion;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ExamQuestionForm extends Model
{
    public $type_id, $title, $text, $question_group_id, $discipline_id;

    private $_examQuestion;
    public $jobEntrant;

    public function __construct(JobEntrant $jobEntrant =null, ExamQuestion $examQuestion = null,
                                $config = [])
    {
        if($examQuestion){
            $this->setAttributes($examQuestion->getAttributes(), false);
            $this->_examQuestion = $examQuestion;
        }

        $this->jobEntrant = $jobEntrant;
        parent::__construct($config);
    }


    public function defaultRules()
    {
        return [
            [['type_id', 'title', 'text', 'discipline_id'], 'required'],
            [['type_id', 'question_group_id','discipline_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        $arrayUnique = [['title'], 'unique', 'targetClass' => ExamQuestion::class, 'targetAttribute' => ['title', 'text'], 'message' => 'Такой вопрос уже внесен в систему'];
        if ($this->_examQuestion) {
            return ArrayHelper::merge($arrayUnique,['filter' => ['<>', 'id', $this->_examQuestion->id]]);
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
        return (new ExamQuestion())->attributeLabels();
    }

}