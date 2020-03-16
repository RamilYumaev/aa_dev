<?php
namespace common\sending\actions;

use common\sending\models\SendingDeliveryStatus;
use yii\data\ActiveDataProvider;
use Yii;

class SendingDeliveryStatusAction extends \yii\base\Action
{
    public $model;
    public $modelType;
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
        $model =  SendingDeliveryStatus::find()->type($this->modelType)
            ->typeSending($this->typeSending)->value($this->model->id);
        $dataProvider = new ActiveDataProvider(['query' => $model, 'pagination' => false]);
        return $this->controller->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $this->model,
            'type' => $this->typeSending,
            'typeModel' => $this->modelType,
        ]);
    }

}