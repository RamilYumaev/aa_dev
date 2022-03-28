<?php
namespace modules\literature\widgets;

use modules\literature\models\LiteratureOlympic;
use Mpdf\Tag\Li;

class ButtonWidget extends \yii\base\Widget
{
    public $userId;

    public function run()
    {
        $model = LiteratureOlympic::findOne(['user_id'=> $this->userId]);
        return $this->render('index', ['model'=>$model]);
    }
}
