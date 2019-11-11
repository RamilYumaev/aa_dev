<?php
namespace common\auth\readRepositories;

use common\auth\models\UserSchool;
use yii\data\ActiveDataProvider;

class UserSchoolReadRepository
{
    public function getUserSchoolsAll($user_id)
    {
        $query = UserSchool::find();
        $query->where(['user_id' => $user_id]);
        $query->orderBy(['edu_year' => SORT_DESC]);
        return $this->getProvider($query);
    }


    private function getProvider(\yii\db\ActiveQuery $query): \yii\data\ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
    }
}