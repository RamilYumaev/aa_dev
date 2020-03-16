<?php

namespace backend\controllers\sending;

use common\sending\forms\SendingCreateForm;
use common\sending\forms\SendingEditForm;
use common\sending\forms\SendingForm;
use common\sending\models\Sending;
use common\sending\services\SendingService;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;

class SendingController extends Controller
{
    private $service;

    public function __construct($id, $module, SendingService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Sending::find()->orderByStatusDeadlineAsc();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}