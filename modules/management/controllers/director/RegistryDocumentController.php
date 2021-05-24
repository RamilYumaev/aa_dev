<?php

namespace modules\management\controllers\director;


use modules\management\forms\RegistryDocumentForm;
use modules\management\models\RegistryDocument;
use modules\management\models\Task;
use modules\management\searches\RegistryDocumentSearch;
use modules\management\services\RegistryDocumentService;
use Yii;
use yii\db\BaseActiveRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RegistryDocumentController extends Controller
{

    private $registryDocumentService;

    public function __construct($id, $module,
                                RegistryDocumentService $registryDocumentService,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->registryDocumentService = $registryDocumentService;
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegistryDocumentSearch(new Task());
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        try {
            $this->registryDocumentService->removeStatus($id);
            Yii::$app->session->setFlash('info', 'Заявка на удаление принята');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new RegistryDocumentForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->registryDocumentService->edit($model->id, $form);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'register' => $model
        ]);
    }

    public function getUser()
    {
        return Yii::$app->user->identity->getId();
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): BaseActiveRecord
    {
        if (($model = RegistryDocument::findOne(['id' => $id, 'user_id' => $this->getUser()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }
}