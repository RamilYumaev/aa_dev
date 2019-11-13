<?php
namespace backend\widgets\olimpic;

use olympic\models\SpecialTypeOlimpic;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class SpecialTypeOlympicWidget extends Widget
{
    public $olympic_id;
    /**
     * @var string
     */
    public $view = 'olympic-special-type/index';

    /**
     * @return string
     */
    public function run()
    {
        $query = SpecialTypeOlimpic::find()->where(['olimpic_id'=> $this->olympic_id ]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
            'olympic_id'=> $this->olympic_id
        ]);
    }
}
