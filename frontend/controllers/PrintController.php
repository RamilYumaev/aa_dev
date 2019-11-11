<?php

namespace frontend\controllers;

use olympic\readRepositories\PrintReadRepository;
use yii\web\Controller;


class PrintController extends Controller
{
    public $layout = 'print';
    private $repository;

    public function __construct($id, $module, PrintReadRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function actionOlimpDocs($template_id, $olympic_id)
    {
        return $this->render('olimp-docs', [
            'result' => $this->repository->getTemplatesAndOlympic($template_id, $olympic_id),
            'olimpiad' => $this->repository->olimpicListRepository->get($olympic_id)]);
    }
}