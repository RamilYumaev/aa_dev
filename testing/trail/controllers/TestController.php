<?php
namespace testing\trail\controllers;

use common\helpers\FlashMessages;
use testing\readRepositories\TestReadOperatorRepository;
use testing\services\AttemptAnswerService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class TestController extends Controller
{
    private $repository;
    private $service;

    public function __construct($id, $module,
                                TestReadOperatorRepository $repository, AttemptAnswerService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
        $this->service = $service;
    }

    /*
    * @param $id
    * @return mixed
    * @throws NotFoundHttpException
    */

    public function actionView($id)
    {
        $this->layout = "@testing/trail/views/layouts/testing.php";
        $get =  Yii::$app->request->get('page');
        if (\Yii::$app->request->post('AnswerAttempt')) {
            try {
                $attempt = $this->repository->isAttempt($id);
                $this->service->addAnswer(\Yii::$app->request->post('AnswerAttempt'),$attempt->id);
                return $this->redirect(['view', 'id'=> $id, "page"=> $get ? $get + 1 : 2 ]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        try {
            $attempt = $this->repository->isAttempt($id);
            $pages = $this->repository->pageCount($id);
            return $this->render('@testing/trail/views/test/view', [
                'time' => $attempt->end,
                'test' => $this->find($id),
                'pages' => $pages,
                'models' => $this->repository->pageOffset($id),
            ]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect('/site/index');
        }
    }

    /*
  * @param $id
  * @return mixed
  * @throws NotFoundHttpException
  */
    public function actionStart($id)
    {
        try {
            return $this->renderAjax('start', [
                'test' => $this->find($id)
            ]);
        } catch (NotFoundHttpException $e) {
        }
    }
        /*
        * @param $id
        * @return mixed
        * @throws NotFoundHttpException
        */
    public function actionEnd($id)
    {
        try {
            return $this->render('end', [
                'test' => $this->find($id)
            ]);
        } catch (NotFoundHttpException $e) {
        }
    }


    /*
   * @param $id
   * @return mixed
   * @throws NotFoundHttpException
   */
    protected function find($id)
    {
        if (($model = $this->repository->find($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(FlashMessages::get()["notFoundHttpException"]);
    }

}