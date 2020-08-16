<?php
namespace modules\exam\widgets\exam;

use modules\exam\models\ExamAttempt;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class TestAttemptStatementWidget extends Widget
{
    public $examId;
    public $userId;
    public $type;
    public $markShow = false;
    /**
     * @var string
     */
    public $view = 'test-attempt/exam-statement';

    public function run()
    {
        $query = ExamAttempt::find()->andWhere(['exam_id' => $this->examId, 'user_id' => $this->userId, 'type' => $this->type ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
            'markShow' => $this->markShow
        ]);
    }
}
