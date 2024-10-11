<?php

namespace frontend\controllers;

use common\helpers\FlashMessages;
use frontend\components\UserNoEmail;
use Mpdf\Tag\U;
use olympic\forms\OlympicUserInformationForm;
use olympic\forms\OlympicUserProfileForm;
use olympic\models\UserOlimpiads;
use olympic\readRepositories\OlimpicReadRepository;
use olympic\repositories\UserOlimpiadsRepository;
use olympic\repositories\OlimpicListRepository;
use olympic\services\UserOlimpiadsService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class UserOlympicController extends Controller
{
    private $service;
    private $repository;
    private $olimpicListRepository;
    private $olimpicReadRepository;

    public function __construct($id, $module, UserOlimpiadsService $service,
                                UserOlimpiadsRepository $repository,
                                OlimpicListRepository $olimpicListRepository,
                                OlimpicReadRepository $olimpicReadRepository,
                                $config = [])
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->olimpicListRepository = $olimpicListRepository;
        $this->olimpicReadRepository = $olimpicReadRepository;
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        return (new UserNoEmail())->redirect();
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws HttpException
     */
    public function actionRegistration($id)
    {
        $this->isGuest();
        try {
            $olympic = $this->olimpicListRepository->get($id);
            if($olympic->olimpic_id == 61) {
                return $this->redirect(['information', 'id' => $id]);
            } else {
                $this->service->add($id, Yii::$app->user->id);
                Yii::$app->session->setFlash('success', 'Спасибо за регистрацию.');
            }

        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $id
     * @param $user_id
     * @return string|\yii\web\Response
     * @throws HttpException
     * @throws NotFoundHttpException
     */

    public function actionInformation($id)
    {
        $this->isGuest();
        $this->layout = "@frontend/views/layouts/olimpic.php";
        $olympic = $this->olimpicListRepository->get($id);
        if($olympic->olimpic_id != 61) {
            return $this->redirect(['olympiads/index']);
        }

        $olympicModel = $this->findOlympic($olympic->olimpic_id);
        $userOlympic = UserOlimpiads::findOne(['olympiads_id' => $olympic->id, 'user_id' => Yii::$app->user->id]);
        if($userOlympic) {
            Yii::$app->session->setFlash('warning', 'Вы не можете редактировать данные.');
            return $this->redirect(['olympiads/registration-on-olympiads', 'id' => $olympic->olimpic_id]);
        }
        $form = new OlympicUserInformationForm($userOlympic);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                if($form->subject_one == $form->subject_two) {
                    throw  new \DomainException('Нельзя выбирать два одинаковых предмета');
                }
                $this->service->add($id, Yii::$app->user->id);
                $userOlympic = UserOlimpiads::findOne(['olympiads_id' => $olympic->id, 'user_id' => Yii::$app->user->id]);
                $userOlympic->information = json_encode([$form->subject_one, $form->subject_two]);
                $userOlympic->save();
                Yii::$app->session->setFlash('success', 'Спасибо за регистрацию');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('information', [
            'olympic' => $olympicModel,
            'model' => $form
        ]);
    }

    public function actionOlympicProfile($id)
    {
        $this->isGuest();
        $this->layout = "@frontend/views/layouts/olimpic.php";
        $olympic = $this->olimpicListRepository->get($id);

        if(!$olympic->getOlympicSpecialityOlimpicList()) {
            return $this->redirect(['olympiads/index']);
        }

        $userOlympic = UserOlimpiads::findOne(['olympiads_id' => $olympic->id, 'user_id' => Yii::$app->user->id]);
        if($userOlympic) {
            Yii::$app->session->setFlash('warning', 'Вы не можете редактировать данные.');
            return $this->redirect(['olympiads/registration-on-olympiads', 'id' => $olympic->olimpic_id]);
        }
        $form = new OlympicUserProfileForm($userOlympic);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->add($id, Yii::$app->user->id);
                $userOlympic = UserOlimpiads::findOne(['olympiads_id' => $olympic->id, 'user_id' => Yii::$app->user->id]);
                $userOlympic->olympic_profile_id = $form->olympic_profile_id;
                if ($form->file) {
                    $userOlympic->setFile($form->file);
                }
                $userOlympic->save();
                Yii::$app->session->setFlash('success', 'Спасибо за регистрацию');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->renderAjax('olympic_profile', [
            'olympicId' => $olympic->id,
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
        if (($model = $this->olimpicReadRepository->find($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(FlashMessages::get()["notFoundHttpException"]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->isGuest();
        try {
            if ($this->isAttempt($id)) {
                Yii::$app->session->setFlash('warning', ' Вы не можете отменить запись, так как начали заочный тур');
            } else {
                $this->service->remove($id);
                Yii::$app->session->setFlash('success', 'Успешно отменена');
            }
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function isGuest() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/index']);
        }
    }

    /**
     * @param integer $id
     * @return mixed
     */
    private function isAttempt($id){
        $userOlympic = $this->repository->get($id);
        $class= \common\auth\helpers\UserSchoolHelper::userClassId($userOlympic->user_id, \common\helpers\EduYearHelper::eduYear());
        $test = \testing\helpers\TestHelper::testAndClassActiveOlympicList($userOlympic->olympiads_id, $class, $userOlympic->olympic_profile_id);
        return \testing\helpers\TestAttemptHelper::isAttempt($test, $userOlympic->user_id);

    }
}