<?php
namespace olympic\models\queries;

use common\auth\models\UserSchool;
use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\models\auth\Profiles;
use olympic\models\OlimpicList;
use olympic\models\PersonalPresenceAttempt;

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

    public function presence()
    {
        return $this->andWhere([PersonalPresenceAttempt::tableName().'.presence_status' => PersonalPresenceAttemptHelper::PRESENCE]);
    }

    public function noAppearance()
    {
        return $this->andWhere([PersonalPresenceAttempt::tableName().'.presence_status' => PersonalPresenceAttemptHelper::NON_APPEARANCE]);
    }

    public function olympic($olympicId)
    {
        return $this->andWhere([PersonalPresenceAttempt::tableName().'.olimpic_id' => $olympicId]);
    }

    public function user($user_id)
    {
        return $this->andWhere([PersonalPresenceAttempt::tableName().'.user_id' => $user_id]);
    }


    public function orderByDescMark()
    {
        return $this->orderBy([PersonalPresenceAttempt::tableName().'.mark'=> SORT_DESC]);
    }

    public function userPresence(OlimpicList $olimpicList)
    {
        return $this->alias(PersonalPresenceAttempt::tableName())
            ->innerJoin(Profiles::tableName(). ' profile', 'profile.user_id = '.PersonalPresenceAttempt::tableName().'.user_id')
            ->olympic($olimpicList->id)
            ->presence()
            ->orderBy(['profile.last_name' => SORT_ASC]);
    }



}