<?php


namespace olympic\forms;


use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicList;
use olympic\models\OlimpicNomination;
use olympic\models\Olympic;
use yii\base\Model;

class OlimpicNominationCreateForm extends Model
{
    public $olimpic_id, $name;


    public function __construct(int $olimpic_id, $config = [])
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
            [['olimpic_id', 'name'], 'required'],
            [['olimpic_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['name', 'unique', 'targetClass' => OlimpicNomination::class, 'message' => 'Такая номинация олимпиады уже есть'],
            [['olimpic_id'], 'exist', 'skipOnError' => true, 'targetClass' => OlimpicList::class, 'targetAttribute' => ['olimpic_id' => 'id']],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return OlimpicNomination::labels();
    }
}