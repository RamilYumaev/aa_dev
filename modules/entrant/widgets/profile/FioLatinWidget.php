<?php
namespace modules\entrant\widgets\profile;

use modules\entrant\models\FIOLatin;
use yii\base\Widget;

class FioLatinWidget extends Widget
{
    public function run()
    {
        $model = FIOLatin::findOne(['user_id' => $this->userId()]);
        return $this->render('fio', [
            'fio'=> $model
        ]);
    }

    private function userId() {
        return \Yii::$app->user->identity->getId();
    }
}
