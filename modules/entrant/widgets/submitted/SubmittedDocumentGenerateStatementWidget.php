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
    private $service;

    public function __construct(StatementService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($config);
    }

    public function init()
    {
        try {
            $this->service->create($this->listCgUser(), $this->modelOne()->type, $this->getIdUser());
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

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
