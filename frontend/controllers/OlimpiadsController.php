<?php


namespace frontend\controllers;

use olympic\forms\SignupOlympicForm;
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
        $olympic = $this->findOlympic($id);
        $form = new SignupOlympicForm($olympic);

        return $this->render('registration-on-olimpiads', [
            'olympic' => $olympic,
            'model' => $form
        ]);
    }


    /*
   * @param $id
   * @return mixed
   * @throws NotFoundHttpException
   */
    protected function findOlympic($id)
    {
        if (!$olympic = $this->repository->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $olympic;
    }




    /*
    * @param $id
    * @return mixed
    * @throws NotFoundHttpException
    */
    public function actionOlympicOld($id)
    {
        if (!$olympic = $this->repository->findOldOlympic($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('olympic-old', [
            'olympic' => $olympic,
        ]);
    }
}