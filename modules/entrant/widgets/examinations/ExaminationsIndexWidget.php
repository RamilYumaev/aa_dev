<?php
namespace modules\entrant\widgets\examinations;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\forms\ExaminationOrCseForm;
use modules\entrant\models\CseViSelect;
use modules\entrant\repositories\CseViSelectRepository;
use modules\entrant\services\CseViSelectService;
use yii\base\Model;
use yii\base\Widget;
use Yii;
use yii\helpers\VarDumper;

class ExaminationsIndexWidget extends Widget
{
    public $userId;
    public $view = "index-data";
    private $repository;

    public function __construct(CseViSelectService $service, CseViSelectRepository $repository, $config = [])
    {
        $this->repository = $repository;
        parent::__construct($config);
    }

    private function modelUser(): ?CseViSelect
    {
        return $this->repository->getUser($this->getIdUser()) ?? null;
    }

    public function run()
    {
        return $this->render($this->view, ['model' => $this->modelUser(), 'exams'=> $this->listExams()]);
    }

    private function listExams() {
        return DictCompetitiveGroupHelper::groupByExams($this->getIdUser());
    }

    private function getIdUser() {
        return $this->userId;
    }

}
