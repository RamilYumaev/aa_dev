<?php


namespace modules\entrant\forms;

use modules\entrant\models\AverageScopeSpo;
use yii\base\Model;

class AverageScopeSpoForm extends Model
{
    public $user_id, $number_of_threes, $number_of_fours, $number_of_fives;
    public $model;

    public function __construct(AverageScopeSpo $averageScopeSpo = null,  $config = [])
    {
        if ($averageScopeSpo) {
            $this->model = true;
            $this->setAttributes($averageScopeSpo->getAttributes(), false);
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['user_id', 'number_of_threes', 'number_of_fours', 'number_of_fives'], 'required'],
            [['number_of_threes', 'number_of_fours', 'number_of_fives'], 'integer', 'min' => 0, 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new AverageScopeSpo())->attributeLabels();
    }

}