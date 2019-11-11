<?php


namespace frontend\controllers;

use common\auth\readRepositories\UserSchoolReadRepository;
use dictionary\readRepositories\DictSchoolsReadRepository;
use olympic\forms\auth\SchooLUserCreateForm;
use olympic\services\UserSchoolService;
use yii\web\Controller;
use yii\web\Response;
use Yii;

class SchoolsController extends Controller
{
    private $repository;
    private $userSchoolReadRepository;
    private $service;

    public function __construct($id,  $module, DictSchoolsReadRepository $repository,
                                UserSchoolReadRepository $userSchoolReadRepository,
                                UserSchoolService $service,
                                $config = [])
    {
        $this->repository = $repository;
        $this->userSchoolReadRepository = $userSchoolReadRepository;
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionAll($country_id, $region_id = null) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['result' => $this->repository->getAllSchools($region_id, $country_id)];

    }

    public function actionIndex() {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $form = new SchooLUserCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->signup($form);
                $this->redirect('index');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }

        $dataProvider =  $this->userSchoolReadRepository->getUserSchoolsAll(Yii::$app->user->id);

        return $this->render('index',
            ['dataProvider' => $dataProvider,
            'model' => $form]);

    }
}