<?php
namespace modules\transfer\widgets\insurance;

use modules\entrant\models\InsuranceCertificateUser;
use yii\base\Widget;

class InsuranceWidget extends Widget
{
    public $userId;
    public $view;
    public function run()
    {
        $model = InsuranceCertificateUser::findOne(['user_id' => $this->userId]);
        return $this->render($this->view, [
            'model'=> $model,
        ]);
    }
}
