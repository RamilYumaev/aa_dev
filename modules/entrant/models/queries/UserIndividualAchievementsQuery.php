<?php


namespace modules\entrant\models\queries;

use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\DictIndividualAchievement;
use modules\dictionary\models\DictIndividualAchievementCg;

class UserIndividualAchievementsQuery extends \yii\db\ActiveQuery
{
    public function cgUserEduLevel($user_id, $eduLevel) {
        return $this->alias('userIa')
            ->innerJoin(DictIndividualAchievement::tableName(), 'dict_individual_achievement.id=userIa.individual_id')
            ->innerJoin(DictIndividualAchievementCg::tableName(), 'dict_individual_achievement_cg.individual_achievement_id=dict_individual_achievement.id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=dict_individual_achievement_cg.competitive_group_id')
            ->andWhere(['userIa.user_id' => $user_id, 'dict_competitive_group.edu_level' => $eduLevel]);
    }


    public function cgUserEduLevelExits($user_id, $eduLevel) {
        return $this->cgUserEduLevel($user_id, $eduLevel)->exists();
    }

    public function cgUserEduLevelAll($user_id, $eduLevel) {
        return $this->cgUserEduLevel($user_id, $eduLevel)->all();
    }

    public function cgUserEduLevelColumn($user_id, $eduLevel) {
        return $this->cgUserEduLevel($user_id, $eduLevel)->select('userIa.individual_id')->column();
    }

    public function individual($individualId) {
         return  $this->andWhere(['individual_id' => $individualId]);
    }

    public function user ($userId) {
        return $this->andWhere(["user_id" => $userId]);
    }

    public function alreadyRecorded($individualId, $userId) {

        return $this->individual($individualId)->user($userId);
    }

}