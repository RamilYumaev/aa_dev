<?php


namespace frontend\controllers;

use olympic\forms\SignupOlympicForm;
use olympic\readRepositories\OlimpicReadRepository;
use olympic\services\OlympicRegisterUserService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class OlimpiadsController extends Controller
{
    private $repository;
    private $service;

    public function __construct($id, $module, OlympicRegisterUserService $service,
                                OlimpicReadRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "@frontend/views/layouts/olimpic.php";

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
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->signup($form);
                Yii::$app->session->setFlash('success', 'Спасибо за регистрацию. Пожалуйста, проверьте ваш почтовый ящик для проверки электронной почты.');
                $this->redirect('index');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }

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
            new NotFoundHttpException('The requested page does not exist.');
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
            new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('olympic-old', [
            'olympic' => $olympic,
        ]);
    }
}