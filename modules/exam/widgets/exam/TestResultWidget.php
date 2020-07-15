<?php
namespace modules\exam\widgets\exam;

use modules\exam\models\ExamResult;
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
        $query = ExamResult::find()->where(['attempt_id'=>$this->attempt_id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
        ]);
    }
}
