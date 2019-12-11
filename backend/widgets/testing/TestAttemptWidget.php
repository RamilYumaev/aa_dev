<?php
namespace backend\widgets\testing;

use testing\models\TestAndQuestions;
use testing\models\TestAttempt;
use testing\models\TestGroup;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class TestAttemptWidget extends Widget
{
    public $test_id;
    /**
     * @var string
     */
    public $view = 'test-attempt/index';

    public function run()
    {
        $query = TestAttempt::find()->test($this->test_id)->orderByMark();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
        ]);
    }
}
