<?php
namespace frontend\widgets\competitive;

use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\CompetitionList;
use modules\dictionary\models\RegisterCompetitionList;
use yii\base\Widget;

class CompetitiveListWidget extends Widget
{
    /* @var $date string */
    public $id;

    public function run()
    {
        $model = CompetitionList::findOne($this->id);
        if(!$model) {
            return  'Ничего не найдено';
        }
        $path = \Yii::getAlias('@modules').$model->json_file;
        $json = file_get_contents($path);
        return $this->render('list-one',['data'=>json_decode($json,true),  'model' => $model]);
    }
}