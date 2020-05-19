<?php
namespace modules\entrant\widgets\examinations;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\forms\ExaminationOrCseForm;
use modules\entrant\models\CseViSelect;
use modules\entrant\repositories\CseViSelectRepository;
use modules\entrant\repositories\StatementRepository;
use modules\entrant\services\CseViSelectService;
use yii\base\Model;
use yii\base\Widget;
use Yii;
use yii\helpers\VarDumper;

class ExaminationsWidget extends Widget
{
    public $view = "index";
    private $service;
    private $repository;
    private $statementRepository;

    public function __construct(CseViSelectService $service, CseViSelectRepository $repository, StatementRepository $statementRepository, $config = [])
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->statementRepository = $statementRepository;
        parent::__construct($config);
    }

    private function modelUser(): ?CseViSelect
    {
        return $this->repository->getUser($this->getIdUser()) ?? null;
    }

    public function run()
    {
        $form = new ExaminationOrCseForm($this->listExams(), $this->modelUser());
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->arrayMark = $form->isArrayMoreResult();
            if (Model::loadMultiple($form->arrayMark, Yii::$app->request->post()) &&
                Model::validateMultiple($form->arrayMark)) {
                try {
                    $this->service->create($form, $this->getIdUser(), $this->repository);
                    Yii::$app->response->redirect(['abiturient/default']);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }

        return $this->render($this->view, ['model' => $form, 'isStatement'=> $this->statementRepository->getStatementStatusNoDraft($this->getIdUser())]);
    }

    private function listExams() {
        return DictCompetitiveGroupHelper::groupByExams($this->getIdUser());
    }

    private function getIdUser() {
        return \Yii::$app->user->identity->getId();
    }

}
