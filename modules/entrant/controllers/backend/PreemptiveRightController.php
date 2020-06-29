<?php

namespace modules\entrant\controllers\backend;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\forms\PreemptiveRightMessageForm;
use modules\entrant\forms\StatementMessageForm;
use modules\entrant\helpers\PreemptiveRightHelper;
use modules\entrant\models\PreemptiveRight;
use modules\entrant\models\Statement;
use modules\entrant\readRepositories\StatementReadRepository;
use modules\entrant\services\PreemptiveRightService;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class PreemptiveRightController extends Controller
{
    private $service;

    public function __construct($id, $module, PreemptiveRightService $service, $config = [])
    {
        $this->service = $service;

        parent::__construct($id, $module, $config);
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
        ];
    }

    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionCreate($typeId)
    {
        $form = new OtherDocumentForm(true, null, false, ['series', 'number', 'authority','date'], [DictIncomingDocumentTypeHelper::TYPE_OTHER]);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form, $typeId);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax("@modules/entrant/views/other-document/_form", ["model" => $form]);
    }

    public function actionRemove($otherId, $typeId)
    {
        try {
            $this->service->remove($otherId, $typeId);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(["index"]);
    }

    public function actionAdd($typeId)
    {
        $other_id = Yii::$app->request->post('other_id');
        if ($other_id) {
            try {
                $this->service->add($other_id, $typeId);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('add');
    }

    /**
     * @param $otherId
     * @param $typeId
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionMessage($otherId, $typeId)
    {
        $model = $this->findModel($otherId, $typeId);
        $form = new PreemptiveRightMessageForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addMessage($otherId, $typeId, $form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('message', [
            'model' => $form,
        ]);
    }

        /**
     * @param $otherId
     * @param $typeId
     * @return mixed
     * @throws NotFoundHttpException
     */

        public function actionSuccess($otherId, $typeId)
        {
            $this->findModel($otherId, $typeId);
            try {
                $this->service->status($otherId, $typeId, PreemptiveRightHelper::SUCCESS);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }

        /**
         * @param $otherId
         * @param $typeId
         * @return mixed
         * @throws NotFoundHttpException
         */

        public function actionDanger($otherId, $typeId)
        {
            $this->findModel($otherId, $typeId);
            try {
                $this->service->status($otherId, $typeId, PreemptiveRightHelper::DANGER);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }


    /**
     * @param $otherId
     * @param $typeId
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($otherId, $typeId): PreemptiveRight
    {
        $query = PreemptiveRight::findOne(['other_id'=> $otherId, 'type_id' => $typeId]);
        if (($model = $query)  !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }





}