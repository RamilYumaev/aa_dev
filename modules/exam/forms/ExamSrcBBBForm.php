<?php

namespace modules\exam\forms;

use modules\exam\models\ExamStatement;
use yii\base\Model;

class ExamSrcBBBForm extends Model
{
    public $src_bbb;

    public function __construct(ExamStatement $examStatement, $config = [])
    {
        $this->setAttributes($examStatement->getAttributes(), false);
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['src_bbb', 'string', 'max'=>255],
            ['src_bbb', 'required'],
            ['src_bbb', 'unique', 'targetClass'=> ExamStatement::class],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
       return [ 'src_bbb' => 'Ссылка BigBlueButton',];
    }
}