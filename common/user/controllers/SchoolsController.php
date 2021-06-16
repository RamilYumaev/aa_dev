<?php

namespace common\user\controllers;

use common\user\readRepositories\UserSchoolReadRepository;
use common\user\readRepositories\UserTeacherReadRepository;
use dictionary\readRepositories\DictSchoolsReadRepository;
use frontend\components\UserNoEmail;
use olympic\forms\auth\SchooLUserCreateForm;
use olympic\helpers\auth\ProfileHelper;
use olympic\services\UserSchoolService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

class SchoolsController extends Controller
{
    private $repository;
    private $userSchoolReadRepository;
    private $service;
    private $teacherReadRepository;
    public $role;


    public function __construct($id, $module, DictSchoolsReadRepository $repository,
                                UserSchoolReadRepository $userSchoolReadRepository,
                                UserTeacherReadRepository $teacherReadRepository,
                                UserSchoolService $service,
                                $config = [])
    {
        $this->repository = $repository;
        $this->userSchoolReadRepository = $userSchoolReadRepository;
        $this->service = $service;
        $this->teacherReadRepository = $teacherReadRepository;
        parent::__construct($id, $module, $config);
        $this->viewPath = '@common/user/views/schools';
    }

    public function actionAll($country_id, $region_id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['result' => $this->repository->getAllSchools($region_id, $country_id)];

    }

    public function beforeAction($action)
    {
        return (new UserNoEmail())->redirect();
    }


    public function actionIndex()
    {

        return $this->render('index', ['role' => $this->role]);

    }

    public function actionCreate()
    {
        if (Yii::$app->user->getIsGuest()) {
            return $this->goHome();
        }
            $form = new SchooLUserCreateForm($this->role);
            $redirect = Yii::$app->request->get("redirect");
            if (is_null($form->country_id)) {
                Yii::$app->session->setFlash('warning', 'Чтобы добавить Вашу учебную организацию, необходимо заполнить профиль.');
                return $this->redirect(['/profile/edit']);
            }
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                try {
                    $this->service->signup($form, $this->role);
                    if ($redirect == "online-registration") {
                        return $this->redirect(['/abiturient']);
                    }

                    if ($redirect == "transfer-registration") {
                        return $this->redirect(['/transfer']);
                    }

                    return $this->redirect('index');
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
            return $this->render('create', ['model' => $form]);
    }

    /*
      * @param $id
      * @return mixed
      * @throws NotFoundHttpException
    */

    public function actionUpdate($id)
    {
        if (Yii::$app->user->getIsGuest()) {
            return $this->goHome();
        }
        $model = $this->find($id);
        $form = new SchooLUserCreateForm($this->role, $model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->update($model->id, $form, $this->role);
                return $this->redirect('index');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('update',
            ['model' => $form]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->getIsGuest()) {
            return $this->goHome();
        }
        try {
            $this->service->remove($id, Yii::$app->user->id, $this->role);
            Yii::$app->session->setFlash('success', 'Успешно удалена запись');
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
    protected function find($id)
    {
        if ($this->role == ProfileHelper::ROLE_STUDENT) {
            return $this->findUserSchool($id);
        }
        return $this->findTeacherSchool($id);
    }


    /*
      * @param $id
      * @return mixed
      * @throws NotFoundHttpException
    */
    protected function findTeacherSchool($id)
    {
        if (($model = $this->teacherReadRepository->getUserSchool($id, Yii::$app->user->id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Запрашиваемая страница не существует.');
    }


    /*
      * @param $id
      * @return mixed
      * @throws NotFoundHttpException
    */
    protected function findUserSchool($id)
    {
        if (($model = $this->userSchoolReadRepository->getUserSchool($id, Yii::$app->user->id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Запрашиваемая страница не существует.');
    }

}