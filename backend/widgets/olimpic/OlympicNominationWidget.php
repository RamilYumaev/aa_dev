<?php
namespace backend\widgets\olimpic;

use olympic\models\OlimpicNomination;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class OlympicNominationWidget extends Widget
{
    public $olympic_id;
    /**
     * @var string
     */
    public $view = 'olympic-nomination/index';

    /**
     * @return string
     */
    public function run()
    {
        $query = OlimpicNomination::find()->where(['olimpic_id'=> $this->olympic_id ]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
            'olympic_id'=> $this->olympic_id
        ]);
    }
}
