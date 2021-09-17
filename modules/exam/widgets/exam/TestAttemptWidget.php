<?php
namespace modules\exam\widgets\exam;

use modules\exam\controllers\backend\ExamAttemptController;
use modules\exam\models\ExamAttempt;
use testing\models\TestAndQuestions;
use testing\models\TestAttempt;
use testing\models\TestGroup;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class TestAttemptWidget extends Widget
{
    public $test_id;
    public $type;
    /**
     * @var string
     */
    public $view = 'test-attempt/index';

    public function run()
    {
        $query = ExamAttempt::find()->test($this->test_id)->type($this->type)->orderByMark();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 400,
            ],
        ]);

        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
        ]);
    }
}
