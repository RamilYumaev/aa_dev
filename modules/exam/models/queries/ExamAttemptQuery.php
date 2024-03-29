<?php
namespace  modules\exam\models\queries;

use common\auth\models\UserSchool;
use modules\exam\models\ExamAttempt;
use olympic\models\OlimpicList;
use olympic\models\PersonalPresenceAttempt;
use testing\helpers\TestHelper;
use testing\models\TestAttempt;

class ExamAttemptQuery  extends  \yii\db\ActiveQuery
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
        return $this->andWhere(['is not', ExamAttempt::tableName().'.mark', null]);
    }

    public function test($test)
    {
        return  $this->andWhere(['test_id'=> $test]);
    }

    public function type($type)
    {
        return  $this->andWhere(['type'=> $type]);
    }

    public function exam($exam)
    {
        return  $this->andWhere(['exam_id'=> $exam]);
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