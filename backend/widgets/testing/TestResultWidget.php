<?php
namespace backend\widgets\testing;

use testing\models\TestAndQuestions;
use testing\models\TestAttempt;
use testing\models\TestGroup;
use testing\models\TestResult;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class TestResultWidget extends Widget
{
    public $attempt_id;
    /**
     * @var string
     */
    public $view = 'test-result/index';

    public function run()
    {
        $query = TestResult::find()->where(['attempt_id'=>$this->attempt_id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
        ]);
    }
}
