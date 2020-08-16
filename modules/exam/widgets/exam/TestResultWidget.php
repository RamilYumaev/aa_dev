<?php
namespace modules\exam\widgets\exam;

use modules\exam\models\Exam;
use modules\exam\models\ExamAttempt;
use modules\exam\models\ExamResult;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class TestResultWidget extends Widget
{
    /**
     * @var ExamAttempt
     */
    public $attempt;
    public $size = 20;
    /**
     * @var string
     */
    public $view = 'test-result/index';

    public function run()
    {
        $query = ExamResult::find()->where(['attempt_id'=>$this->attempt->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->size,
            ],
        ]);

        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
            'attempt' => $this->attempt
        ]);
    }
}
