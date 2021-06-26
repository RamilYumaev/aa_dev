<?php
namespace modules\transfer\widgets\transfer;


use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\StatementIndividualAchievements;
use modules\transfer\models\StatementTransfer;
use yii\base\Widget;
use Yii;

class StatementTransferFrontendWidget extends Widget
{
    public $userId;


    public function run()
    {
        $model = StatementTransfer::find()->andWhere(['user_id' => $this->userId])->andWhere([">", "status", StatementHelper::STATUS_DRAFT])->one();
        return $this->render('index-frontend', [
            'model'=> $model,
        ]);
    }
}
