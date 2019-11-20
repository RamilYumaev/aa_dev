<?php
namespace testing\models\queries;

use common\auth\models\UserSchool;
use olympic\models\OlimpicList;
use testing\helpers\TestHelper;

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

}