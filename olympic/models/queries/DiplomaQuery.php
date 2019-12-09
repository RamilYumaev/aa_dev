<?php
namespace olympic\models\queries;

use common\auth\models\UserSchool;
use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\models\auth\Profiles;
use olympic\models\Diploma;
use olympic\models\OlimpicList;
use olympic\models\PersonalPresenceAttempt;

class DiplomaQuery  extends  \yii\db\ActiveQuery
{

    public function olympic($olympicId)
    {
        return $this->andWhere([Diploma::tableName().'.olimpic_id' => $olympicId]);
    }
}