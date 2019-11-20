<?php

namespace frontend\controllers;

use olympic\readRepositories\PrintReadRepository;
use yii\data\ActiveDataProvider;
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


    public function actionOlimpResult($olympic_id, $numTour = null)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $this->repository->getResultOlympic($olympic_id, $numTour),
            'sort' => false,
            'pagination' => false,
        ]);

        return $this->render('olimp-result', [
            'dataProvider' => $dataProvider,
            'numTour'=> $numTour,
            'olimpiad' => $this->repository->olimpicListRepository->get($olympic_id)]);

    }
}