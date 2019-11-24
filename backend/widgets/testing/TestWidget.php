<?php
namespace backend\widgets\testing;
use testing\models\Test;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class TestWidget extends Widget
{
    public $olympic_id;
    /**
     * @var string
     */
    public $view = 'test/index';


    public function run()
    {
        $query = Test::find()->where(['olimpic_id'=> $this->olympic_id ]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
            'olympic_id'=> $this->olympic_id
        ]);
    }
}
