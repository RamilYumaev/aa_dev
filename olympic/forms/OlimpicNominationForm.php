<?php


namespace olympic\forms;


use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicNomination;
use olympic\models\Olympic;
use yii\base\Model;

class OlimpicNominationForm extends Model
{
    public $olimpic_id, $name;


    public function __construct(OlimpicNomination $nomination = null, $config = [])
    {
        if ($nomination) {
            $this->olimpic_id = $nomination->olimpic_id;
            $this->name = $nomination->name;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['olimpic_id', 'name'], 'required'],
            [['olimpic_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['olimpic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Olympic::class, 'targetAttribute' => ['olimpic_id' => 'id']],
        ];
    }

    public function olimpicList(): array
    {
        return OlympicHelper::olimpicList();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return OlimpicNomination::labels();
    }
}