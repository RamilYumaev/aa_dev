<?php
namespace modules\entrant\widgets\profile;

use olympic\models\auth\Profiles;
use yii\base\Widget;

class ProfileWidget extends Widget
{
    public $userId;
    public $view = "index";
    public function run()
    {
        $model = Profiles::find()->where(['user_id' => $this->userId])->one();
        return $this->render($this->view, [
            'profile'=> $model
        ]);
    }
}
