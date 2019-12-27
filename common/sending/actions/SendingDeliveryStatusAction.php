<?php
namespace common\sending\actions;

use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\models\SendingDeliveryStatus;
use olympic\models\OlimpicList;
use yii\data\ActiveDataProvider;
use Yii;

class SendingDeliveryStatusAction extends \yii\base\Action
{
    /* @var  $olympicModel OlimpicList */
    public $olympicModel;
    private $typeSending;

    private $viewPath = "@common/sending/actions/views/sending-delivery-status";

    public function __construct($id, $controller, $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->typeSending = Yii::$app->request->get('typeSending');

    }

    public function run()
    {
        $this->controller->viewPath = $this->viewPath;
        $model =  SendingDeliveryStatus::find()->type(SendingDeliveryStatusHelper::TYPE_OLYMPIC)
            ->typeSending($this->typeSending)->value($this->olympicModel->id);
        $dataProvider = new ActiveDataProvider(['query' => $model, 'pagination' => false]);
        return $this->controller->render('index', [
            'dataProvider' => $dataProvider,
            'olympic' => $this->olympicModel,
            'type' => $this->typeSending
        ]);
    }

}