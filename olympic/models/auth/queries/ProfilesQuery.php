<?php


namespace olympic\models\auth\queries;


use common\auth\models\UserSchool;
use common\helpers\EduYearHelper;
use olympic\models\auth\Profiles;
use olympic\models\OlimpicList;
use yii\db\ActiveQuery;
use yii\db\Expression;

class ProfilesQuery extends ActiveQuery
{
    public function getAllMembers($neededUser, OlimpicList $olympic)
    {
        return $this->
        select(['concat_ws(" ", last_name, first_name, patronymic) as fio, phone, user.email as email, dict_schools.name as school, dict_class.name as class'])
            ->innerJoin(UserSchool::tableName(), Profiles::tableName() . '.`user_id` =' . UserSchool::tableName() . '.`user_id`')
            ->innerJoin(\common\auth\models\User::tableName(), 'user.id = profiles.user_id')
            ->leftJoin('dict_schools', 'user_school.school_id = dict_schools.id')
            ->leftJoin('dict_class', 'user_school.class_id = dict_class.id')
            ->andWhere(['in', '{{profiles}}.user_id', $neededUser])
            ->andWhere([UserSchool::tableName() . '.`edu_year`' => $olympic->year])
            ->asArray()->all();
    }

    public function joinUser()
    {
        return $this->innerJoinWith('user');
    }

    public function submittedUserStatus($status)
    {
        return $this->joinUser()
            ->andWhere(['status' => $status]);
    }

    public function selectFullNameWithEmail()
    {
        return $this->select(new Expression("concat_ws(' ', last_name, first_name, patronymic, email)"));
    }

    public function selectFullName()
    {
        return $this->select(new Expression("concat_ws(' ', last_name, first_name, patronymic)"));
    }

    public function selectForSwitcher()
    {
        return $this->select(new Expression("`user_id` as 'id',
        concat_ws(' ', last_name, first_name, patronymic, email) as 'text'"));

    }

    public function country($countryId)
    {

        return $this->andWhere(['country_id' => $countryId]);
    }

    public function region($regionId)
    {
        return $this->andWhere(['region_id' => $regionId]);
    }

}