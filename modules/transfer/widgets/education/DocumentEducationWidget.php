<?php
namespace modules\transfer\widgets\education;

use common\auth\models\UserSchool;
use modules\entrant\models\DocumentEducation;
use yii\base\Widget;

class DocumentEducationWidget extends Widget
{
    public $userId;
    public $view = "index";
    public function run()
    {
        return $this->render($this->view, [
            'isUserSchool' => $this->userSchool()
        ]);
    }

    private function userSchool() : bool
    {
        return UserSchool::find()->where(['user_id' => $this->userId])->exists();
    }

}
