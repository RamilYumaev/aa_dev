<?php


namespace frontend\controllers;

use olympic\readRepositories\OlimpicReadRepository;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OlimpiadsController extends Controller
{
    private $repository;

    public function __construct($id, $module, OlimpicReadRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = $this->repository->getAll();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /*
    * @param $id
    * @return mixed
    * @throws NotFoundHttpException
    */
    public function actionRegistrationOnOlimpiads($id)
    {
        if (!$olympic = $this->repository->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('registration-on-olimpiads', [
            'olympic' => $olympic,
        ]);
    }



}