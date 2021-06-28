<?php
namespace modules\transfer\widgets\transfer;

use common\auth\models\UserSchool;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\DocumentEducation;
use modules\transfer\models\CurrentEducationInfo;
use modules\transfer\models\StatementTransfer;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class TransferBackendWidget extends Widget
{
    public $view = "index-list";

    public function run()
    {
        $query = StatementTransfer::find()->andWhere(['status' => StatementHelper::STATUS_WALT]);
        $dataProvider = new ActiveDataProvider(['query'=> $query, 'pagination' => ['pageSize' =>  4]]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
        ]);
    }
}
