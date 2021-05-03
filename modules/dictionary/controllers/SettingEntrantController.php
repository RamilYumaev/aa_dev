<?php

namespace modules\dictionary\controllers;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\components\RegisterCompetitiveListComponent;
use modules\dictionary\forms\SettingCompetitionListForm;
use modules\dictionary\forms\SettingEntrantForm;
use modules\dictionary\models\RegisterCompetitionList;
use modules\dictionary\models\SettingCompetitionList;
use modules\dictionary\models\SettingEntrant;
use modules\dictionary\searches\RegisterCompetitionListSearch;
use modules\dictionary\searches\SettingCompetitionListSearch;
use modules\dictionary\searches\SettingEntrantSearch;
use modules\dictionary\services\SettingEntrantService;
use modules\usecase\ControllerClass;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class SettingEntrantController extends ControllerClass
{

    public function __construct($id, $module,
                                SettingEntrantService $service,
                                SettingEntrant $model,
                                SettingEntrantForm $formModel,
                                SettingEntrantSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->model = $model;
        $this->formModel = $formModel;
        $this->searchModel = $searchModel;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['dev']
                    ]
                ],
            ],
        ];
    }


    public function actionCreate()
    {
        /**
         * @var $form Model
         */
        $form = new $this->formModel;
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                /** @var SettingEntrant $model */
                $model = $this->service->create($form);
                if($model->isSettingCompetitionList()) {
                    return $this->redirect(['setting-competition-list','se'=>$model->id]);
                }
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param $se
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */

    public function actionSettingCompetitionList($se)
    {
        /** @var SettingEntrant $modelSettingEntrant */
        $modelSettingEntrant = $this->findModel($se);
        if(!$modelSettingEntrant->isSettingCompetitionList()) {
            return $this->redirect(['index']);
        }
        $model = SettingCompetitionList::findOne($modelSettingEntrant->id);
        $form = new SettingCompetitionListForm($model, ['se_id'=> $se]);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->createOrEditSCL($form);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('competition-list/form', [
            'model' => $form, 'modelSettingEntrant' => $modelSettingEntrant
        ]);
    }

    public function actionAuto($status)
    {
        try {
            $this->service->updateAll($status);
            Yii::$app->session->setFlash('info',"Успешно обновлено");
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['setting-competition-list-index']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */

    public function actionSend($id)
    {
        if (($model = RegisterCompetitionList::findOne($id)) == null) {
            throw new NotFoundHttpException('Такой страницы не существует.');
        }
        try {
            $cgs = explode(',', $model->ais_cg_id);
            $array = ['ais_id'=> $cgs ? $cgs : $model->ais_cg_id,
                'faculty_id' => $model->faculty_id, 'speciality_id' => $model->speciality_id];
            $register = (new RegisterCompetitiveListComponent(RegisterCompetitionList::TYPE_HANDLE, false))
                ->push(array($array), $model->settingCompetitionList, date('Y-m-d'));
            Yii::$app->session->setFlash($register->isStatusError() ? 'error' : 'info',
                'Статус: '. $register->statusName.($register->isStatusError() ?'Сообщение: '.$register->error_message:''));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * @return mixed
     */
    public function actionSettingCompetitionListIndex()
    {
        $searchModel = new SettingCompetitionListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $countAuto = SettingCompetitionList::find()->auto()->count();

        return $this->render('competition-list/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'countAuto' => $countAuto
        ]);
    }

    /**
     * @return mixed
     */
    public function actionRegisterCompetitionListIndex()
    {
        $searchModel = new RegisterCompetitionListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('competition-list/register/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
}