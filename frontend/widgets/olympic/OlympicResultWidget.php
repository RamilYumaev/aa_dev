<?php
namespace frontend\widgets\olympic;

use olympic\readRepositories\UserOlympicReadRepository;
use olympic\models\OlimpicList;
use Yii;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class OlympicResultWidget extends Widget
{
    /* @var $olympic OlimpicList */
    public $model;

    private $view = 'olympic-result/index';

    /**
     * @return
     */
    public function run()
    {
        return $this->render($this->view, [
            'olympic' => $this->model
        ]);
    }
}