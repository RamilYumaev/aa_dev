<?php
namespace common\user\readRepositories;


use teacher\models\UserTeacherJob;
use yii\data\ActiveDataProvider;

class UserTeacherReadRepository
{
    public function getUserSchoolsAll($user_id)
    {
        $query = UserTeacherJob::find();
        $query->where(['user_id' => $user_id]);
        $query->orderBy(['id' => SORT_DESC]);
        return $this->getProvider($query);
    }

    public function getUserSchool($id, $user_id)
    {
        $query = UserTeacherJob::findOne(['id' => $id,'user_id' => $user_id]);
        return $query;
    }

    private function getProvider(\yii\db\ActiveQuery $query): \yii\data\ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
    }
}