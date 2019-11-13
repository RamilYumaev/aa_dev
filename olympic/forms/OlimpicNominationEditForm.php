<?php


namespace olympic\forms;


use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicList;
use olympic\models\OlimpicNomination;
use olympic\models\Olympic;
use yii\base\Model;

class OlimpicNominationEditForm extends Model
{
    public $olimpic_id, $name, $_olympicNomination;


    public function __construct(OlimpicNomination $nomination, $config = [])
    {
        $this->olimpic_id = $nomination->olimpic_id;
        $this->name = $nomination->name;
        $this->_olympicNomination = $nomination;

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
            ['name', 'unique', 'targetClass' => OlimpicNomination::class, 'filter' => ['<>', 'id', $this->_olympicNomination->id], 'message' => 'Такая номинация олимпиады уже есть'],
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