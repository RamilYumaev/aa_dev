<?php


namespace frontend\controllers;

use common\helpers\FlashMessages;
use frontend\components\UserNoEmail;
use olympic\forms\SignupOlympicForm;
use olympic\readRepositories\OlimpicReadRepository;
use olympic\services\OlympicRegisterUserService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class OlympiadsController extends Controller
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

    public function beforeAction($action)
    {
        return (new UserNoEmail())->redirect();
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

    /**
     * @param $faculty
     * @return mixed
     */
    public function actionFilial($faculty)
    {
        $this->layout = "@frontend/views/layouts/olimpic.php";
        $dataProvider = $this->repository->getAllFilial($faculty);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $faculty
     * @return mixed
     */
    public function actionMagistracy($faculty)
    {
        $this->layout = "@frontend/views/layouts/olimpic.php";
        $dataProvider = $this->repository->getAllMagistracy($faculty);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $faculty
     * @return mixed
     */
    public function actionBaccalaureate($faculty)
    {
        $this->layout = "@frontend/views/layouts/olimpic.php";
        $dataProvider = $this->repository->getAllBaccalaureate($faculty);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /*
    * @param $id
    * @return mixed
    * @throws NotFoundHttpException
    */
    public function actionRegistrationOnOlympiads($id)
    {
        $this->layout = "@frontend/views/layouts/olimpic.php";
        $olympic = $this->findOlympic($id);
        $form = new SignupOlympicForm($olympic);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->signup($form);
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

        }

        return $this->render('registration-on-olympiads', [
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
        if (($model = $this->repository->find($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(FlashMessages::get()["notFoundHttpException"]);
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