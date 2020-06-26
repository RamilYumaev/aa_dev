<?php

namespace modules\entrant\widgets\passport;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\models\PassportData;
use yii\base\Widget;

class BirthDocumentWidget extends Widget
{
    public $view;
    public $userId;


    public function run()
    {
        $model = PassportData::findOne(['user_id' => $this->userId, 'main_status' => false,
            'type' => [DictIncomingDocumentTypeHelper::ID_BIRTH_DOCUMENT, DictIncomingDocumentTypeHelper::ID_BIRTH_FOREIGNER_DOCUMENT]]);
        return $this->render($this->view, [
            'model' => $model,
            'userId'=>$this->userId,
        ]);
    }

}
