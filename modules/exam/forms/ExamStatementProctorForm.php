<?php

namespace modules\exam\forms;
use modules\exam\models\ExamStatement;
use yii\base\Model;

class ExamStatementProctorForm extends Model
{
    public $proctor_user_id;

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
            ['proctor_user_id', 'integer'],
            ['proctor_user_id', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
       return [ 'proctor_user_id'=> 'ФИО проктора'];
    }
}