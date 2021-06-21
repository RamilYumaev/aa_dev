<?php
namespace modules\entrant\widgets\anketa;

use common\auth\models\User;
use common\auth\models\UserSchool;
use modules\entrant\models\Anketa;
use modules\entrant\models\AnketaCi;
use modules\entrant\models\DocumentEducation;
use yii\base\Widget;

class AnketaCiWidget extends Widget
{
    public $userId;
    public $view = 'index-ci';
    public function run()
    {
        $user = User::findOne($this->userId);
        $model = AnketaCi::findOne(['email' => $user->email]);
        return $this->render($this->view, [
            'anketa'=> $model,
        ]);
    }

}
