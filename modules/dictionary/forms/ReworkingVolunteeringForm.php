<?php


namespace modules\dictionary\forms;


use modules\dictionary\models\ReworkingVolunteering;
use yii\base\Model;

class ReworkingVolunteeringForm extends Model
{
    public $text, $count_hours, $recall_text;
    const FIRST = 'first';
    const TWO = 'two';

    public function __construct(ReworkingVolunteering $reworkingVolunteering = null, $config = [])
    {
        if($reworkingVolunteering){
            $this->setAttributes($reworkingVolunteering->getAttributes(), false);
        }

        parent::__construct($config);
    }


    public function rules()
    {
        return [
            [['text', 'count_hours'], 'required', 'on' => self::FIRST],
            [['recall_text',], 'required', 'on' => self::TWO],
            [['text', 'recall_text'], 'string'],
            [['count_hours'], 'integer'],
            [['count_hours'], 'integer', 'min'=> 1, 'max' => 8],
        ];
    }

    public function attributeLabels()
    {
        return (new ReworkingVolunteering())->attributeLabels();
    }
}