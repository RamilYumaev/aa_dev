<?php

namespace modules\entrant\widgets\submitted;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\SubmittedDocuments;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;

class SubmittedDocumentGenerateStatementWidget extends Widget
{
    public $userId;
    public $formCategory;
    public $eduLevel;
    private $view = "detail";

    public function run()
    {
        return $this->render($this->view, ['submitted' => $this->modelOne(),
            'userId' =>  $this->getIdUser(), 'userCg' => $this->listCgUser(), 'formCategory' => $this->formCategory]);
    }

    private function listCgUser() {
        return DictCompetitiveGroupHelper::groupByFacultySpecialityAllUser($this->getIdUser(), $this->eduLevel, DictCompetitiveGroupHelper::categoryForm()[$this->formCategory]);
    }

    private function getIdUser() {
        return $this->userId;
    }

    private function modelOne(){
       return SubmittedDocuments::findOne(['user_id' => $this->getIdUser()]);
    }

}
