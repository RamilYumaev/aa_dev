<?php
namespace modules\entrant\widgets\agreement;

use modules\entrant\models\Agreement;
use yii\base\Widget;

class AgreementWidget extends Widget
{
    public $userId;
    public $view;
    public function run()
    {
        $model = Agreement::findOne(['user_id' => $this->userId]);
        return $this->render($this->view, [
            'model'=> $model,
        ]);
    }
}
