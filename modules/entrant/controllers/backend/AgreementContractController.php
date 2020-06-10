<?php


namespace modules\entrant\controllers\backend;


use common\helpers\EduYearHelper;
use modules\entrant\forms\AgreementForm;
use modules\entrant\models\Agreement;
use modules\entrant\searches\StatementAgreementContractSearch;
use modules\entrant\searches\StatementConsentSearch;
use modules\entrant\services\AgreementService;
use yii\web\Controller;
use Yii;

class AgreementContractController extends Controller
{
    private $service;

    public function __construct($id, $module, AgreementService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StatementAgreementContractSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel(): ?Agreement
    {
      return Agreement::findOne([ 'user_id' => Yii::$app->user->identity->getId(), 'year' =>EduYearHelper::eduYear()]);
    }
}