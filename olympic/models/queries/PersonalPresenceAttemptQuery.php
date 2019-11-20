<?php


namespace olympic\models\queries;


use common\auth\models\UserSchool;
use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\models\OlimpicList;
use olympic\models\Olympic;


class PersonalPresenceAttemptQuery  extends  \yii\db\ActiveQuery
{
    /**
     * @return $this
     */
    public function olympicAttempt(OlimpicList $olimpicList)
    {
        return $this->alias('ppa')
            ->innerJoin(UserSchool::tableName(). ' school', 'school.user_id = ppa.user_id')
        ->andWhere(['ppa.olimpic_id' => $olimpicList->id])
            ->andWhere(['school.edu_year' => $olimpicList->year])
        ->andWhere(['ppa.presence_status' => PersonalPresenceAttemptHelper::PRESENCE])
        ->orderBy(['ppa.mark' => SORT_DESC]);
    }

}