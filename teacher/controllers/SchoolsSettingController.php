<?php

namespace teacher\controllers;

use common\auth\forms\UserEmailForm as SchoolEmailForm;
use common\user\readRepositories\UserTeacherReadRepository;
use dictionary\models\DictSchools;
use dictionary\services\DictSchoolsService;
use olympic\services\UserOlimpiadsService;
use olympic\services\UserSchoolService as TeacherSchoolService;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class SchoolsSettingController extends Controller
{
    private $service;
    private $schoolService;
    private $teacherReadRepository;
    private $olimpiadsService;

    public function __construct($id, $module, DictSchoolsService $service,
                                TeacherSchoolService $schoolService,
                                UserOlimpiadsService $olimpiadsService,
                                UserTeacherReadRepository $teacherReadRepository,
                                $config = [])
    {
        $this->service = $service;
        $this->schoolService = $schoolService;
        $this->teacherReadRepository  = $teacherReadRepository;
        $this->olimpiadsService = $olimpiadsService;
        parent::__construct($id, $module, $config);
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionAddEmail($id)
    {
        $form = new SchoolEmailForm(DictSchools::class, false);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addEmail($id, $form);
                Yii::$app->session->setFlash('success', ' Элеткронная почта успешно добавлена.');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect('/schools/index');
        }

        return $this->renderAjax('add-email', ['model' => $form, 'id'=>$id]);
    }

    public function actionSend($id)
    {
        $model = $this->find($id);
        try {
            $this->schoolService->send($model->id);
            Yii::$app->session->setFlash('success', 'Письмо отправлено!');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSendUser($id)
    {
        try {
            $this->olimpiadsService->sendUser($id);
            Yii::$app->session->setFlash('success', 'Письмо отправлено!');
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
        if (($model = $this->teacherReadRepository->getUserSchool($id, Yii::$app->user->id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Запрашиваемая страница не существует.');
    }

}
