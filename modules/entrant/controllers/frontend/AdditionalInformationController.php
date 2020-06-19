<?php
namespace modules\entrant\controllers\frontend;

use modules\entrant\forms\AdditionalInformationForm;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\Address;
use modules\entrant\models\Anketa;
use modules\entrant\services\AdditionalInformationService;
use yii\web\Controller;
use Yii;
use function GuzzleHttp\Psr7\normalize_header;

class AdditionalInformationController extends Controller
{
    private $service;

    public function __construct($id, $module, AdditionalInformationService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $model = $this->findModel() ?? null;
        $form = new AdditionalInformationForm($this->getUserId(), $model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->createOrUpdate($form);
                return $this->redirect(['default/index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'model' => $form,
            'additional' => $model,
            'anketaMoscow' => $this->anketa()->isMoscow(),
            'addressMoscow' => $this->address(),

        ]);
    }

    protected function findModel(): ?AdditionalInformation
    {
      return AdditionalInformation::findOne([ 'user_id' => $this->getUserId() ]);
    }

    private function getUserId()
    {
        return  Yii::$app->user->identity->getId();
    }

    protected function anketa()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect('default/index');
        }
        return Anketa::findOne(['user_id' => $this->getUserId()]);
    }

    protected function address()
    {
        if (Address::find()->where(['type'=>AddressHelper::TYPE_REGISTRATION, 'user_id'=>$this->getUserId()])->exists()) {
            return Address::findOne(['type'=>AddressHelper::TYPE_REGISTRATION, 'user_id'=>$this->getUserId()]);
        }
        return null;
    }
}