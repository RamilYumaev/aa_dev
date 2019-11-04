<?php
namespace backend\widgets\olimpic;

use olympic\forms\search\OlimpicListSearch;
use yii\base\Widget;
use Yii;

class OlipicListInOLymipViewWidget extends Widget
{
    public $model;

    /**
     * @var string
     */
    public $view = 'olimpic-list-in-olymp-view/index';


    public function run()
    {
        $searchModel = new OlimpicListSearch($this->model);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render($this->view, [
            'model' => $this->model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
