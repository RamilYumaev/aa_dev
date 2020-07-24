<?php
namespace modules\exam\widgets\violation;

use modules\exam\models\ExamStatement;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class ExamViolationWidget extends Widget
{
    public $view = "index";
    /* @var $examStatement ExamStatement */
    public $examStatement;

    public function run()
    {
        $dataProvider = new ActiveDataProvider(['query'=> $this->examStatement->getViolation(), 'pagination' => [
            'pageSize' =>  4,
        ],]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
            'examStatement' => $this->examStatement,
        ]);
    }

}
