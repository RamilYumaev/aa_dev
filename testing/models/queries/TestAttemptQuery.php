<?php
namespace testing\models\queries;

use common\auth\models\UserSchool;
use olympic\models\OlimpicList;
use olympic\models\PersonalPresenceAttempt;
use testing\helpers\TestHelper;
use testing\models\TestAttempt;

class TestAttemptQuery  extends  \yii\db\ActiveQuery
{
    /**
     * @return $this
     */
    public function olympicAttempt(OlimpicList $olimpicList)
    {
        return $this->alias('tta')
            ->innerJoin(UserSchool::tableName(). ' school', 'school.user_id = tta.user_id')
            ->andWhere(['in', 'tta.test_id', TestHelper::testIdOlympic($olimpicList->id)])
            ->andWhere(['school.edu_year' => $olimpicList->year])
            ->andWhere(['is not', 'tta.mark', null])
            ->orderBy(['tta.mark' => SORT_DESC]);
    }

    public function isNotNullMark()
    {
        return $this->andWhere(['is not', TestAttempt::tableName().'.mark', null]);
    }

    public function inTestIdOlympic(OlimpicList $olimpicList)
    {
      return  $this->andWhere(['in', 'test_id', TestHelper::testIdOlympic($olimpicList->id)]);
    }

    public function test($test)
    {
        return  $this->andWhere(['test_id'=> $test]);
    }

    public function  isNotNullRewards() {
        return $this->andWhere(['is not', TestAttempt::tableName().'.reward_status', null]);
    }

    public function user($user)
    {
        return  $this->andWhere(['user_id'=>$user]);
    }

    public function orderByMark()
    {
        return  $this->orderBy(['mark' => SORT_DESC]);
    }


}