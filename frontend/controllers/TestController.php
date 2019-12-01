<?php


namespace frontend\controllers;


use common\helpers\FlashMessages;
use frontend\components\UserNoEmail;
use testing\readRepositories\TestReadRepository;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TestController extends Controller
{
    private $repository;

    public function __construct($id, $module,
                                TestReadRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    public function beforeAction($action)
    {
        return (new UserNoEmail())->redirect();
    }

    /*
    * @param $id
    * @return mixed
    * @throws NotFoundHttpException
    */

    public function actionView($id)
    {

        if (\Yii::$app->request->post()) {
            return $this->renderContent(Html::tag('pre',
                VarDumper::dumpAsString(
                    \Yii::$app->request->post()
                )));
        }
        try {
            return $this->render('view', [
                'test' => $this->find($id),
                'pages' => $this->repository->quentTestsCount($id),
                'models' => $this->repository->pageOffset($id),
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