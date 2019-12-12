<?php
namespace operator\widgets\olimpic;

use olympic\forms\search\OlympicSearch;
use yii\base\Widget;
use Yii;

class OlympicWidget extends Widget
{

    /**
     * @var string
     */
    public $view = 'olympic/index';


    public function run()
    {
        $searchModel = new OlympicSearch(Yii::$app->user->identity->getId());
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render($this->view, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
