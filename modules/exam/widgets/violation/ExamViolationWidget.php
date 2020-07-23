<?php
namespace modules\exam\widgets\violation;

use modules\exam\models\ExamViolation;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class ExamViolationWidget extends Widget
{
    public $view = "index";
    public $examStatementId;

    public function run()
    {
        $query = ExamViolation::find()->andWhere(['exam_statement_id' => $this->examStatementId]);
        $dataProvider = new ActiveDataProvider(['query'=> $query, 'pagination' => [
            'pageSize' =>  4,
        ],]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
            'examStatementId' => $this->examStatementId,
        ]);
    }

}
