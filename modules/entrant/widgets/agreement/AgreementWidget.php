<?php
namespace modules\entrant\widgets\agreement;

use common\auth\models\UserSchool;
use common\helpers\EduYearHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\DocumentEducation;
use yii\base\Widget;

class AgreementWidget extends Widget
{
    public $userId;

    public $view;
    public function run()
    {
        $model = Agreement::findOne([ 'user_id' => $this->userId, 'year' =>EduYearHelper::eduYear()]);
        return $this->render($this->view, [
            'model'=> $model,
        ]);
    }
}
