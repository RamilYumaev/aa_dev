<?php
namespace backend\widgets\dod;

use dod\models\DateDod;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class DateDodWidget extends Widget
{
    public $dod_id;

    /**
     * @var string
     */
    public $view = 'date-dod/index';

    /**
     * @return string
     */
    public function run()
    {
        $query = DateDod::find()->where(['dod_id'=> $this->dod_id ])->orderBy(['date_time'=> SORT_DESC]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
            'dod_id'=>$this->dod_id
        ]);
    }
}
