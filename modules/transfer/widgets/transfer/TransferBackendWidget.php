<?php
namespace modules\transfer\widgets\transfer;

use common\auth\models\UserSchool;
use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\DocumentEducation;
use modules\transfer\models\CurrentEducationInfo;
use modules\transfer\models\StatementTransfer;
use modules\transfer\readRepositories\StatementTransferReadRepository;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class TransferBackendWidget extends Widget
{
    public $view = "index-list";

    public function run()
    {
        $query = (new StatementTransferReadRepository($this->getJobEntrant()))->readData();
        if($this->getJobEntrant()->isAgreement()) {
            $query->andWhere(['status' => StatementHelper::STATUS_WALT]);
        }
        $dataProvider = new ActiveDataProvider(['query'=> $query, 'pagination' => ['pageSize' =>  8]]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
        ]);
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return \Yii::$app->user->identity->jobEntrant();
    }
}
