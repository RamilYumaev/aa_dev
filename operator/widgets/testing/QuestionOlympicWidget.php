<?php
namespace operator\widgets\testing;

use testing\models\TestGroup;
use testing\models\TestQuestion;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class QuestionOlympicWidget extends Widget
{
    public $olympic_id;
    /**
     * @var string
     */
    public $view = 'question-olympic/index';

    public function run()
    {
        $query = TestQuestion::find()->where([ 'olympic_id'=> $this->olympic_id]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
             'olympic_id' => $this->olympic_id
        ]);
    }
}
