<?php

namespace common\user\controllers;

use common\user\form\SchoolAndClassForm;
use common\user\readRepositories\UserSchoolReadRepository;
use common\user\readRepositories\UserTeacherReadRepository;
use common\user\search\SchoolSearch;
use dictionary\models\DictSchools;
use dictionary\readRepositories\DictSchoolsReadRepository;
use frontend\components\UserNoEmail;
use olympic\forms\auth\SchooLUserCreateForm;
use olympic\helpers\auth\ProfileHelper;
use olympic\services\UserSchoolService;
use yii\bootstrap\ActiveForm;
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
        $searchModel = new SchoolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'role' => $this->role
        ]);
    }

    public function actionCreate()
    {
        if (Yii::$app->user->getIsGuest()) {
            return $this->goHome();
        }
        $redirect = Yii::$app->request->get("redirect");
        $form = new SchoolAndClassForm();
        $form->setScenario(SchoolAndClassForm::UPDATE_CREATE);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                try {
                    $this->service->addNewSchool($form, Yii::$app->user->id);
                    if ($redirect == "online-registration") {
                        return $this->redirect(['/abiturient']);
                    }

                    if ($redirect == "transfer-registration") {
                        return $this->redirect(['/transfer']);
                    }
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());

                }
                return $this->redirect('index');
            }
            return $this->renderAjax('_form_s', ['model' => $form]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */

    public function actionUpdate($id)
    {
        if (Yii::$app->user->getIsGuest()) {
            return $this->goHome();
        }
        $model = $this->findSchool($id);
        $form = new SchoolAndClassForm($model);
        $form->setScenario(SchoolAndClassForm::UPDATE_CREATE);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->renameSchool($form, Yii::$app->user->id);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect('index');
        }
        return $this->renderAjax('_form_s', ['model' => $form]);
    }

    /**
 * @param $id
 * @return string|Response
 * @throws NotFoundHttpException
 */

    public function actionSelect($id)
    {
        if (Yii::$app->user->getIsGuest()) {
            return $this->goHome();
        }
        $model = $this->findSchool($id);
        $form = new SchoolAndClassForm($model);
        $form->setScenario(SchoolAndClassForm::SELECT_REPLACE);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->selectSchool($form, Yii::$app->user->id);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect('index');
        }
        return $this->renderAjax('_form_s', ['model' => $form]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */

    public function actionChangeClass($id)
    {
        if (Yii::$app->user->getIsGuest()) {
            return $this->goHome();
        }
        $model = $this->find($id);
        $form = new SchoolAndClassForm($model->school);
        $form->class_id = $model->class_id;
        $form->setScenario(SchoolAndClassForm::SELECT_REPLACE);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->changeClass($model->id, $form, Yii::$app->user->id);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect('index');
        }
        return $this->renderAjax('_form_s', ['model' => $form]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */

    public function actionChange($id)
    {
        if (Yii::$app->user->getIsGuest()) {
            return $this->goHome();
        }
        $model = $this->findSchool($id);
        $form = new SchoolAndClassForm($model);
        $form->setScenario(SchoolAndClassForm::SELECT_REPLACE);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->changeSchool($form, Yii::$app->user->id);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect('index');
        }
        return $this->renderAjax('_form_s', ['model' => $form]);
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

    /*
    * @param $id
    * @return mixed
    * @throws NotFoundHttpException
  */
    protected function findSchool($id)
    {
        if (($model = DictSchools::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Запрашиваемая страница не существует.');
    }


}