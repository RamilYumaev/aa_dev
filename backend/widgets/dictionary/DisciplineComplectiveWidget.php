<?php
namespace backend\widgets\dictionary;

use dictionary\models\DisciplineCompetitiveGroup;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class DisciplineComplectiveWidget extends Widget
{
    public $competitive_group_id;

    /**
     * @var string
     */
    public $view = 'discipline-complective/index';

    /**
     * @return string
     */
    public function run()
    {
        $query = DisciplineCompetitiveGroup::find()->where(['competitive_group_id'=> $this->competitive_group_id ])->orderBy(['priority'=> SORT_ASC]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
            'competitive_group_id'=>$this->competitive_group_id
        ]);
    }
}
