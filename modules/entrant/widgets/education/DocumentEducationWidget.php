<?php
namespace modules\entrant\widgets\education;

use common\auth\models\UserSchool;
use modules\entrant\models\DocumentEducation;
use yii\base\Widget;

class DocumentEducationWidget extends Widget
{
    public $userId;
    public function run()
    {
        $model = DocumentEducation::findOne(['user_id' => $this->userId()]);
        return $this->render('index', [
            'document_education'=> $model,
            'isUserSchool' => $this->userSchool()
        ]);
    }

    private function userSchool() : bool
    {
        return UserSchool::find()->where(['user_id' => $this->userId()])->exists();
    }

    private function userId() {
        return $this->userId;
    }
}
