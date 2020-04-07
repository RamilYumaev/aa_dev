<?php
namespace modules\entrant\widgets\other;

use modules\entrant\models\OtherDocument;
use yii\base\Widget;

class ExemptionOrPatriotWidget extends Widget
{
    public $type = 'patriot';

    public function run()
    {
        $model = OtherDocument::findOne($this->arrayCondition());
        return $this->render('other', [
            'other' => $model,
            'type' => $this->type,
        ]);
    }

    public function arrayCondition() {
        if($this->type === "patriot")
        {
            return ['type' => 43,'user_id' => $this->getIdUser() ];
        }
        return ['exemption_id'=> true, 'user_id' => $this->getIdUser()];
    }

    private function getIdUser() {
        return \Yii::$app->user->identity->getId();
    }


}
