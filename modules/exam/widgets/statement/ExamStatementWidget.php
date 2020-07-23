<?php
namespace modules\exam\widgets\statement;

use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\readRepositories\StatementReadRepository;
use modules\exam\models\ExamStatement;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class ExamStatementWidget extends Widget
{
    public $view = "index";
    public $userId;
    public $examId;

    public function run()
    {
        $query = ExamStatement::find()->andWhere(['entrant_user_id' => $this->userId,'exam_id' => $this->examId]);
        $dataProvider = new ActiveDataProvider(['query'=> $query, 'pagination' => [
            'pageSize' =>  4,
        ],]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
        ]);
    }

}
