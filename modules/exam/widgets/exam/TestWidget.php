<?php
namespace modules\exam\widgets\exam;
use modules\exam\models\ExamTest;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class TestWidget extends Widget
{
    public $exam_id;
    /**
     * @var string
     */
    public $view = 'test/index';

    public function run()
    {
        $query = ExamTest::find()->where(['exam_id' => $this->exam_id]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
            'exam_id'=> $this->exam_id
        ]);
    }
}
