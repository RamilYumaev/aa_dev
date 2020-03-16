<?php


namespace frontend\controllers;

use common\helpers\FlashMessages;
use dod\forms\SignUpDodRemoteUserForm;
use dod\models\UserDod;
use dod\readRepositories\DateDodReadRepository;
use dod\repositories\UserDodRepository;
use dod\services\UserDodService;
use frontend\components\UserNoEmail;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class UserDodController extends Controller
{
    private $service;
    private $repository;

    public function __construct($id, $module, UserDodService $service, DateDodReadRepository $repository, $config = [])
    {
        $this->service = $service;
        $this->repository = $repository;
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
     */
    public function actionRegistration($id, $type = null)
    {
        $this->isGuest();
        try {
            $this->service->add($id, Yii::$app->user->id, $type);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['dod/index']);
    }

    /*
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionRegistrationOnDodRemoteUser($id)
    {
        $this->isGuest();
        $dod = $this->findDod($id);
        $this->isUserDod($dod->id);
        $form = new SignUpDodRemoteUserForm($dod);
        if (is_null($form->schoolUser->country_id)) {
            Yii::$app->session->setFlash('warning', 'Чтобы добавить Вашу учебную организацию, необходимо заполнить профиль.');
            return $this->redirect(['/profile/edit']);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addRemoteEdu($form, Yii::$app->user->id);
                \Yii::$app->session->setFlash('success', FlashMessages::get()["successDodRegistrationInsideCabinet"]." Накануне мероприятия на почту придет ссылка на трансляцию");
                return $this->redirect(['dod/index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            };
        }
        return $this->render('registration-on-dod-remote-user', [
            'dod' => $dod,
            'model' => $form
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->isGuest();
        try {
            $this->service->remove($id, Yii::$app->user->id);
            Yii::$app->session->setFlash('success', 'Успешно отменена');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['dod/index']);
    }



    protected function isGuest() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['dod/index']);
        }
    }

    /*
    * @param $id
    * @return mixed
    */
    public function isUserDod($id) {
        try {
            (new UserDodRepository())->getDodUser($id, Yii::$app->user->id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['dod/index']);
        }

    }


    /*
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findDod($id)
    {
        if (!$dod = $this->repository->find($id)) {
            new NotFoundHttpException('Такой страницы не существует.');
        }
        return $dod;
    }
}