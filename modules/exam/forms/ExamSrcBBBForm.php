<?php

namespace modules\exam\forms;

use modules\exam\models\ExamStatement;
use yii\base\Model;

class ExamSrcBBBForm extends Model
{
    public $src_bbb, $time, $voz;
    public $exam_st;

    public function __construct(ExamStatement $examStatement, $config = [])
    {
        $this->setAttributes($examStatement->getAttributes(), false);
        $this->exam_st = $examStatement;
        $this->voz = $examStatement->information->voz_id ? true : false;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['src_bbb', 'string', 'max'=>255],
            ['time', 'string', 'max'=>5],
            [['src_bbb','time'], 'required'],
           $this->exam_st->src_bbb ? ['src_bbb', 'unique', 'filter'=> ['<>', 'id', $this->exam_st->id], 'targetClass'=> ExamStatement::class] : ['src_bbb', 'unique', 'targetClass'=> ExamStatement::class],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
       return [ 'src_bbb' => 'Ссылка BigBlueButton',
           'time' => 'Время начала',];
    }
}