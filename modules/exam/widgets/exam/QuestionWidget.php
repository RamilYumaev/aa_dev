<?php
namespace backend\widgets\testing;

use testing\models\TestGroup;
use testing\models\TestQuestion;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class QuestionWidget extends Widget
{
    public $group_id;
    /**
     * @var string
     */
    public $view = 'question/index';

    public function run()
    {
        $query = TestQuestion::find()->where([ 'group_id'=> $this->group_id]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
             'group_id' => $this->group_id
        ]);
    }
}
