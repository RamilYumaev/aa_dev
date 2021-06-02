<?php


namespace modules\entrant\controllers\frontend;


use dictionary\helpers\DictCountryHelper;
use modules\entrant\forms\AddressForm;
use modules\entrant\models\Address;
use modules\entrant\services\AddressService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class AddressController extends Controller
{
    private $service;

    public function __construct($id, $module, AddressService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
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

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $referrer = Yii::$app->request->get("referrer");
        $form = new AddressForm($this->getUserId());
        $form->country_id = DictCountryHelper::RUSSIA;
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                if($referrer) {
                    return $this->redirect('/transfer/default/index');
                }
                return $this->redirect(['default/index']);
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
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $referrer = Yii::$app->request->get("referrer");
        $model = $this->findModel($id);
        $form = new AddressForm($model->user_id,$model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($model->id, $form);
                if($referrer) {
                    return $this->redirect('/transfer/default/index');
                }
                return $this->redirect(['default/index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Address
    {
        if (($model = Address::findOne(['id'=>$id, 'user_id' => $this->getUserId()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    private function getUserId()
    {
        return  Yii::$app->user->identity->getId();
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionDelete($id)
    {
        $this->findModel($id);
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
       return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param integer $id
     * @param integer $type
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCopy($id, $type)
    {
        $this->findModel($id);
        try {
            $this->service->copy($id, $type);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
       return $this->redirect(Yii::$app->request->referrer);
    }
}