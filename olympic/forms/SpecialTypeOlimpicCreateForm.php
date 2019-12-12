<?php


namespace olympic\forms;

use dictionary\helpers\DictSpecialTypeOlimpicHelper;
use olympic\models\SpecialTypeOlimpic;
use yii\base\Model;

class SpecialTypeOlimpicCreateForm extends  Model
{
    public $olimpic_id;
    public $special_type_id;

    public function __construct($olimpic_id, $config = [])
    {
        $this->olimpic_id = $olimpic_id;
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
            ['special_type_id','unique',  'targetClass' => SpecialTypeOlimpic::class, 'targetAttribute' => ['olimpic_id', 'special_type_id'],
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

    public  function specialTypeOlimpicList(): array
    {
      return  DictSpecialTypeOlimpicHelper::specialTypeOlimpicList();
    }

}