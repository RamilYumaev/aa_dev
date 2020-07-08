<?php
namespace modules\entrant\widgets\other;

use modules\entrant\models\OtherDocument;
use yii\base\Widget;

class WithoutOtherWidget extends Widget
{
    public $view = "without";
    public $userId;

    public function run()
    {
        $model = OtherDocument::find()->where(['user_id' =>  $this->userId])->andWhere(['not',['without'=> null ]])->one();
        return $this->render($this->view, [
            'other' => $model,
        ]);
    }




}
