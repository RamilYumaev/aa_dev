<?php
namespace modules\entrant\widgets\information;


use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\AisOrderTransfer;
use modules\entrant\models\Infoda;
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

class InfodaWidget extends Widget
{
    public $userId;

    public function run()
    {
        $query = $this->userAis()  ? Infoda::findOne(['incoming_id'=> $this->userAis()->incoming_id]) : null;
        return $this->render('index-infoda', [
            'infoda'=> $query,
        ]);
    }

    private function userAis() {
        return UserAis::findOne(['user_id'=> $this->userId]);
    }
}
