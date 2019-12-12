<?php
namespace operator\widgets\result;

use olympic\models\OlimpicList;
use olympic\models\PersonalPresenceAttempt;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class ResultAttemptWidget extends Widget
{
    /**
     * @var OlimpicList
     */
    public $olympic;

    /**
     * @var string
     */
    public $view = 'result-attempt/index';

    /**
     * @var string
     */
    public $viewRead = 'result-read-attempt/index';


    public function run()
    {
        $query = PersonalPresenceAttempt::find()->olympic($this->olympic->id)->orderByDescMark();

        $dataProvider = new ActiveDataProvider(['query' => $query, 'pagination' => false]);

        $view = $this->olympic->isResultEndTour() ? $this->viewRead : $this->view;
        return $this->render($view, [
            'dataProvider' => $dataProvider,
            'olympic'=> $this->olympic
        ]);
    }
}
