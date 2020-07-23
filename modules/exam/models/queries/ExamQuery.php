<?php
namespace  modules\exam\models\queries;

use common\auth\models\UserSchool;
use modules\exam\models\ExamAttempt;
use olympic\models\OlimpicList;
use olympic\models\PersonalPresenceAttempt;
use testing\helpers\TestHelper;
use testing\models\TestAttempt;

class ExamQuery  extends  \yii\db\ActiveQuery
{
   public function  discipline($ids) {
       return $this->andWhere(['discipline_id' => $ids]);
   }
}