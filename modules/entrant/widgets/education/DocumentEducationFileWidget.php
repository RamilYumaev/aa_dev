<?php
namespace modules\entrant\widgets\education;

use common\auth\models\UserSchool;
use modules\entrant\models\DocumentEducation;
use yii\base\Widget;

class DocumentEducationFileWidget extends Widget
{
    public $userId;
    public function run()
    {
        $model = DocumentEducation::findOne(['user_id' => $this->userId]);
        return $this->render('file', [
            'model'=> $model,
        ]);
    }

}
