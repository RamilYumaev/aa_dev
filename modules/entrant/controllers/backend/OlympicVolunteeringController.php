<?php


namespace modules\entrant\controllers\backend;

use common\helpers\EduYearHelper;
use common\helpers\FlashMessages;
use modules\dictionary\models\JobEntrant;
use modules\dictionary\services\VolunteeringService;
use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicList;
use olympic\models\UserOlimpiads;
use olympic\services\UserOlimpiadsService;
use testing\readRepositories\TestReadRepository;
use testing\services\AttemptAnswerService;
use testing\services\TestAttemptService;
use yii\base\ExitException;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class OlympicVolunteeringController extends Controller
{
    private $service;
    private $userService;
    private $testAttemptService;
    private $testReadRepository;
    private $attemptAnswerService;

    public function __construct($id, $module, VolunteeringService $service, UserOlimpiadsService $userService,
                                TestAttemptService $testAttemptService, TestReadRepository $testReadRepository,
                                AttemptAnswerService $attemptAnswerService,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->userService = $userService;
        $this->testAttemptService = $testAttemptService;
        $this->attemptAnswerService = $attemptAnswerService;
        $this->testReadRepository = $testReadRepository;

    }

    public function beforeAction($event)
    {
        if(!$this->getJobEntrant()) {
            Yii::$app->session->setFlash("warning", 'Страница недоступна');
            Yii::$app->getResponse()->redirect(['site/index']);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
        return true;
    }

    public function actionIndex() {
        $modelAll = OlimpicList::find()->joinWith('olympic')->andWhere([
            'prefilling' => OlympicHelper::PREFILING_BAS,
            'year' => EduYearHelper::eduYear(),
            'is_volunteering' => true])->all();

        return $this->render('index', ['olympics' => $modelAll, 'userId' => $this->getJobEntrant()->user_id]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws \yii\web\HttpException
     */
    public function actionRegistration($id)
    {
        try {
            $this->userService->addVolunteering($id, $this->getJobEntrant()->user_id);
            Yii::$app->session->setFlash('success', 'Спасибо за регистрацию.');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionStart($test_id)
    {
        try {
            $testAttempt = $this->testAttemptService->create($test_id);
            return $this->redirect(['view', 'id' => $testAttempt->test_id]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionEnd($test_id)
    {
        try {
            $this->testAttemptService->end($test_id);
            return $this->redirect(['index']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /*
    * @param $id
    * @return mixed
    * @throws NotFoundHttpException
    */

    public function actionView($id)
    {
        $this->layout = "@frontend/views/layouts/testing.php";
        $get =  Yii::$app->request->get('page');
        if (\Yii::$app->request->post('AnswerAttempt')) {
            try {
                $attempt = $this->testReadRepository->isAttempt($id);
                $this->attemptAnswerService->addAnswer(\Yii::$app->request->post('AnswerAttempt'),$attempt->id);
                return $this->redirect(['view', 'id'=> $id, "page"=> $get ? $get + 1 : 2 ]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        try {
            $attempt = $this->testReadRepository->isAttempt($id);
            $pages = $this->testReadRepository->pageCount($id);
            return $this->render('view', [
                'time' => $attempt->end,
                'test' => $this->find($id),
                'pages' => $pages,
                'models' => $this->testReadRepository->pageOffset($id),
            ]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect('index');
        }
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws HttpException
     */
    public function actionDelete($id)
    {
        try {
            if ($this->isAttempt($id)) {
                Yii::$app->session->setFlash('warning', ' Вы не можете отменить запись, так как начали заочный тур');
            } else {
                $this->userService->remove($id);
                Yii::$app->session->setFlash('success', 'Успешно отменена');
            }
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws HttpException
     */
    private function isAttempt($id){
        $userOlympic = $this->findModel($id);
        $test = \testing\helpers\TestHelper::testActiveOlympicList($userOlympic->olympiads_id);
        return \testing\helpers\TestAttemptHelper::isAttempt($test, $userOlympic->user_id);
    }

    /**
     * @param $olympicId
     * @return UserOlimpiads|null
     * @throws HttpException
     */
    protected function findModel($id) {
        if(!$model = UserOlimpiads::findOne(['user_id'=> $this->getJobEntrant()->user_id, 'id'=> $id])) {
            throw  new NotFoundHttpException('Нет такой записи');
        }
        return $model;
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }

    /*
* @param $id
* @return mixed
* @throws NotFoundHttpException
*/
    public function actionStartTest($id)
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
    public function actionEndTest($id)
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
        if (($model = $this->testReadRepository->find($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(FlashMessages::get()["notFoundHttpException"]);
    }

}