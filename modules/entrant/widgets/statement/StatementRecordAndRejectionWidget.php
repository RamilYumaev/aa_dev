<?php
namespace modules\entrant\widgets\statement;


use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\AisOrderTransfer;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\StatementRejectionRecord;
use modules\entrant\models\UserAis;
use modules\entrant\services\StatementIndividualAchievementsService;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;
use function GuzzleHttp\Psr7\normalize_header;

class StatementRecordAndRejectionWidget extends Widget
{
    public $userId;
    public $isDownload = false;

    public function run()
    {
        $query = $this->userAis()  ? AisOrderTransfer::find()->andWhere(['incoming_id'=> $this->userAis()->incoming_id])->all() : null;
        $query2 = StatementRejectionRecord::find()->andWhere(['user_id'=> $this->userId])->all();
        return $this->render('index-record', [
            'orderTransfer'=> $query,
            'statementRecord'=> $query2,
            'isDownload' => $this->isDownload
        ]);
    }

    private function userAis() {
        return UserAis::findOne(['user_id'=> $this->userId]);
    }
}
