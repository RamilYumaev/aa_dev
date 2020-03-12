<?php


namespace frontend\controllers;

use dod\forms\SignupDodForm;
use dod\readRepositories\DateDodReadRepository;
use dod\services\DodRegisterUserService;
use frontend\components\UserNoEmail;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class DodController extends Controller
{
    private $repository;
    private $service;

    public function __construct($id, $module, DodRegisterUserService $service,
                                DateDodReadRepository $repository, $config = [])
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
        return $this->render('index');
    }

    /*
    * @param $id
    * @return mixed
    * @throws NotFoundHttpException
    */
    public function actionRegistrationOnDod($id)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('index');
        }
        $dod = $this->findDod($id);
        $form = new SignupDodForm($dod);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->signup($form);
                Yii::$app->session->setFlash('success', 'Спасибо за регистрацию. 
                Вам отправлено письмо. Для активации учетной записи, пожалуйста, следуйте инструкциям в письме.');
                $this->redirect('index');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('registration-on-dod', [
            'dod' => $dod,
            'model' => $form
        ]);
    }

    /*
   * @param $id
   * @return mixed
   * @throws NotFoundHttpException
   */
    public function actionDod($id)
    {
        $dod = $this->findDod($id);
        return $this->render('dod', [
            'dod' => $dod
        ]);
    }

    /*
 * @param $id
 * @return mixed
 * @throws NotFoundHttpException
 */
    protected function findDod($id)
    {
        if (!$olympic = $this->repository->find($id)) {
            new NotFoundHttpException('The requested page does not exist.');
        }
        return $olympic;
    }
}