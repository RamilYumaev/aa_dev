<?php
namespace modules\exam\widgets\exam;

use modules\exam\models\ExamResult;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class TestResultTableWidget extends Widget
{
    public $attemptId;
    /**
     * @var string
     */
    public $urlTest;
    public $view = 'test-result/index-table';

    public function run()
    {
        $query = ExamResult::find()->where(['attempt_id'=>$this->attemptId])->select(['priority', 'attempt_id', 'result'])->orderBy(['priority'=>SORT_ASC]);

        return $this->render($this->view, [
            'results' => $query->all(),
            'url'=> $this->urlTest
        ]);
    }
}
