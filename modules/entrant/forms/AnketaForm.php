<?php

namespace modules\entrant\forms;


use modules\entrant\models\Anketa;
use yii\base\Model;

class AnketaForm extends Model
{
    public $user_id, $citizenship_id, $edu_finish_year, $current_edu_level, $category_id;
    private $_anketaForm;

    public function __construct(Anketa $anketa = null, $config = [])
    {
        if ($anketa) {
            $this->citizenship_id = $anketa->citizenship_id;
            $this->edu_finish_year = $anketa->edu_finish_year;
            $this->current_edu_level = $anketa->current_edu_level;
            $this->category_id = $anketa->category_id;
            $this->user_id = \Yii::$app->user->identity->getId();

        }else{
            $this->user_id = \Yii::$app->user->identity->getId();

        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['user_id', 'citizenship_id','current_edu_level','category_id'], 'integer'],
            [['user_id', 'citizenship_id', 'edu_finish_year','current_edu_level','category_id'], 'required'],
            [['edu_finish_year'], 'date', 'format' => 'yyyy'],

        ];
    }

    public function attributeLabels()
    {
        return (new Anketa())->attributeLabels();
    }
}