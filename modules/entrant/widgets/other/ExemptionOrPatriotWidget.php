<?php
namespace modules\entrant\widgets\other;

use modules\entrant\models\OtherDocument;
use yii\base\Widget;

class ExemptionOrPatriotWidget extends Widget
{
    public $type = 'patriot';
    public $view = "other";
    public $userId;

    public function run()
    {
        $model = $this->arrayCondition();
        return $this->render($this->view, [
            'other' => $model,
            'type' => $this->type,
        ]);
    }

    public function arrayCondition() {
        if($this->type === "patriot")
        {
            return OtherDocument::findOne(['type' => 43,'user_id' =>$this->userId ]);
        }
        return  OtherDocument::find()->where(['user_id' =>  $this->userId])->andWhere(['not',['exemption_id'=> null ]])->one();
    }



}
