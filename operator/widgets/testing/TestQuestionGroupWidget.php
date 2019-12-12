<?php
namespace operator\widgets\testing;
use testing\forms\search\TestQuestionGroupSearch;
use testing\models\TestQuestionGroup;
use yii\base\Widget;
use Yii;
use yii\data\ActiveDataProvider;

class TestQuestionGroupWidget extends Widget
{
    public $model;
    /**
     * @var string
     */
    public $view = 'test-question-group/index';


    public function run()
    {
        $searchModel = new TestQuestionGroupSearch($this->model->id);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render($this->view, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'olympic_id'=> $this->model->id
        ]);
    }
}
