<?php


namespace olympic\forms;

use olympic\models\SpecialTypeOlimpic;
use yii\base\Model;

class SpecialTypeOlimpicCreateForm extends  Model
{
    public $olimpic_id;
    public $special_type_id;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['olimpic_id', 'special_type_id'], 'required'],
            [['olimpic_id', 'special_type_id'], 'integer'],
            ['olimpic_id', 'unique',  'targetClass' => SpecialTypeOlimpic::class, 'targetAttribute' => ['olimpic_id', 'special_type_id'],
                'message' => 'Этот вид уже назначен данной олимпиаде']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return SpecialTypeOlimpic::labels();
    }

}