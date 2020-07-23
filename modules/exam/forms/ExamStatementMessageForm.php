<?php

namespace modules\exam\forms;
use modules\exam\models\ExamStatement;
use yii\base\Model;

class ExamStatementMessageForm extends Model
{
    public $message;

    public function __construct(ExamStatement $file, $config = [])
    {
        $this->setAttributes($file->getAttributes(), false);
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['message', 'string', 'max'=>255],
            ['message', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
       return [ 'message'=> 'Сообщение'];
    }
}