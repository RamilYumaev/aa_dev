<?php


namespace olympic\models\auth\queries;


use common\auth\models\UserSchool;
use common\helpers\EduYearHelper;
use olympic\models\auth\Profiles;
use yii\db\ActiveQuery;

class ProfilesQuery extends ActiveQuery
{
public function getAllMembers($neededUser)
{
    return $this->
        select(['concat_ws(" ", last_name, first_name, patronymic) as fio, phone, user.email as email, dict_schools.name as school, dict_class.name as class'])
        ->innerJoin(UserSchool::tableName(), Profiles::tableName() . '.`user_id` =' . UserSchool::tableName() . '.`user_id`')
        ->innerJoin(\common\auth\models\User::tableName(), 'user.id = profiles.user_id')
        ->leftJoin('dict_schools', 'user_school.school_id = dict_schools.id')
        ->leftJoin('dict_class', 'user_school.class_id = dict_class.id')
        ->andWhere(['in', '{{profiles}}.user_id', $neededUser])
        ->andWhere([UserSchool::tableName() . '.`edu_year`' => EduYearHelper::eduYear()])
        ->asArray()->all();
}

}