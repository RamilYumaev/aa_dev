<?php

namespace modules\entrant\widgets\submitted;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\SubmittedDocuments;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;

class SubmittedDocumentGenerateStatementWidget extends Widget
{
    private $view = "detail";

    public function run()
    {
        return $this->render($this->view, ['submitted' => $this->modelOne(),
            'userId' =>  $this->getIdUser(), 'userCg' => $this->listCgUser()]);
    }

    private function listCgUser() {
        return DictCompetitiveGroupHelper::groupByFacultySpecialityAllUser($this->getIdUser());
    }

    private function getIdUser() {
        return \Yii::$app->user->identity->getId();
    }

    private function modelOne(){
       return SubmittedDocuments::findOne(['user_id' => $this->getIdUser()]);
    }

}
