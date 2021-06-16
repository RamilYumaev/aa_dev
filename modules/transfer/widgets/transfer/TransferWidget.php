<?php
namespace modules\transfer\widgets\transfer;

use common\auth\models\UserSchool;
use modules\entrant\models\DocumentEducation;
use modules\transfer\models\CurrentEducationInfo;
use yii\base\Widget;

class TransferWidget extends Widget
{
    public $userId;
    public $view = "index";

    public function run()
    {
        $model = CurrentEducationInfo::findOne(['user_id'=> $this->userId]);
        return $this->render($this->view, [
            'model' => $model
        ]);
    }
}
