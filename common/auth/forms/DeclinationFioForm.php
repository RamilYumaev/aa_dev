<?php


namespace common\auth\forms;


use common\auth\models\DeclinationFio;
use yii\base\Model;

class DeclinationFioForm extends  Model
{
    public $nominative, $genitive, $dative, $accusative, $ablative, $prepositional;

    public function __construct(DeclinationFio $declinationFio, $config = [])
    {
        $this->nominative = $declinationFio->nominative;
        $this->genitive = $declinationFio->genitive;
        $this->dative = $declinationFio->dative;
        $this->accusative = $declinationFio->accusative;
        $this->ablative = $declinationFio->ablative;
        $this->prepositional = $declinationFio->prepositional;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['nominative', 'genitive', 'dative', 'accusative', 'ablative', 'prepositional'], 'required'],
            [['nominative', 'genitive', 'dative', 'accusative', 'ablative', 'prepositional'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return DeclinationFio::labels();
    }


}