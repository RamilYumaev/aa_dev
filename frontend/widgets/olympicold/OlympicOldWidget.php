<?php
namespace frontend\widgets\olympicold;

use olympic\helpers\OlympicHelper;
use yii\base\Widget;
use olympic\models\OlimpicList;

class OlympicOldWidget extends Widget
{
    public $model;
    /**
     * @var string
     */
    public $view = 'olympic-old/index';
    /**
     * @return string
     */
    public function run()
    {
        $model = OlimpicList::find()
            ->where(['olimpic_id' => $this->model->id, 'prefilling' => OlympicHelper::PREFILING_BAS])
            ->andWhere(['<>','id', $this->model->olympicOneLast->id])

            ->orderBy(['year'=>SORT_DESC])
            ->all();
        return $this->render($this->view, [
            'model' => $model
        ]);
    }
}