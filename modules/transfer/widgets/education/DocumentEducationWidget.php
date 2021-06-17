<?php
namespace modules\transfer\widgets\education;

use common\auth\models\UserSchool;
use modules\entrant\models\DocumentEducation;
use modules\transfer\models\CurrentEducation;
use modules\transfer\models\CurrentEducationInfo;
use yii\base\Widget;

class DocumentEducationWidget extends Widget
{
    public $userId;
    public $view = "index";
    public $referrer = '';

    public function run()
    {
        $model = CurrentEducation::findOne(['user_id'=> $this->userId]);

        return $this->render($this->view, [
            'referrer' => $this->referrer,
            'isUserSchool' => $this->userSchool(),
            'model' => $model
        ]);
    }

    private function userSchool() : bool
    {
        return UserSchool::find()->where(['user_id' => $this->userId])->exists();
    }

}
