<?php
namespace modules\entrant\widgets\anketa;

use common\auth\models\UserSchool;
use modules\entrant\models\Anketa;
use modules\entrant\models\DocumentEducation;
use yii\base\Widget;

class AnketaWidget extends Widget
{
    public $userId;
    public $view = "index";
    public function run()
    {
        $model = Anketa::findOne(['user_id' => $this->userId]);
        return $this->render($this->view, [
            'anketa'=> $model,
        ]);
    }

}
