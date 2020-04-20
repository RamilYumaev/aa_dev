<?php

namespace modules\entrant\widgets\submitted;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\SubmittedDocuments;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;

class SubmittedDocumentWidget extends Widget
{
    private $view = "index";

    public function run()
    {
        return $this->render($this->view,
            ['submitted' => SubmittedDocuments::findOne(['user_id' => $this->getIdUser()]),
            'userId' =>  $this->getIdUser()]);
    }

    private function getIdUser() {
        return \Yii::$app->user->identity->getId();
    }
}
