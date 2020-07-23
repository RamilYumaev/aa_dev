<?php
namespace modules\exam\widgets\exam;

use modules\exam\models\ExamAttempt;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class TestAttemptStatementWidget extends Widget
{
    public $examId;
    public $userId;
    /**
     * @var string
     */
    public $view = 'test-attempt/exam-statement';

    public function run()
    {
        $query = ExamAttempt::find()->andWhere(['exam_id' => $this->examId, 'user_id' => $this->userId]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
        ]);
    }
}
