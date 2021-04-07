<?php

namespace modules\dictionary\controllers;
use modules\dictionary\forms\JobEntrantForm;
use modules\dictionary\forms\SettingCompetitionListForm;
use modules\dictionary\forms\SettingEntrantForm;
use modules\dictionary\models\JobEntrant;
use modules\dictionary\models\SettingCompetitionList;
use modules\dictionary\models\SettingEntrant;
use modules\dictionary\searches\JobEntrantSearch;
use modules\dictionary\searches\SettingEntrantSearch;
use modules\dictionary\services\JobEntrantService;
use modules\dictionary\services\SettingEntrantService;
use modules\usecase\ControllerClass;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

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
                if($model->isZUK()) {
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
        if(!$modelSettingEntrant->isZUK()) {
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
        return $this->render('setting-competition-list', [
            'model' => $form, 'modelSettingEntrant' => $modelSettingEntrant
        ]);
    }
}