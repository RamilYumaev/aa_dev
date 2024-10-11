<?php
namespace backend\widgets\testing;
use olympic\models\OlimpicList;
use testing\models\Test;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class TestWidget extends Widget
{
    /**
     * @var OlimpicList
     */
    public $olympic;
    /**
     * @var string
     */
    public $view = 'test/index';


    public function run()
    {
        $query = Test::find()->where(['olimpic_id'=> $this->olympic->id]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
            'olympic'=> $this->olympic
        ]);
    }
}
