<?php
namespace teacher\models\queries;


use olympic\models\Diploma;
use olympic\models\OlimpicList;
use olympic\models\UserOlimpiads;

class UserTeacherJobQuery extends \yii\db\ActiveQuery
{
    /**
     * @return $this
     */

    public function diploma()
    {
        return  $this->alias('utj')
            ->innerJoin(UserOlimpiads::tableName() . ' uo', 'uo.teacher_id = utj.user_id')
            ->innerJoin(OlimpicList::tableName() . ' olympic', 'olympic.id = uo.olympiads_id')
            ->innerJoin(Diploma::tableName() . ' diploma', 'diploma.user_id = uo.user_id')
            ->select(['utj.school_id'])
            ->andWhere(['uo.status' => UserOlimpiads::ACTIVE])
            ->andWhere(['utj.user_id' => \Yii::$app->user->identity->getId()]);
    }

    /**
     * @return $this
     */

    public function diplomaSchool($school_id)
    {
        return  $this->alias('utj')
            ->innerJoin(UserOlimpiads::tableName() . ' uo', 'uo.teacher_id = utj.user_is')
            ->innerJoin(OlimpicList::tableName() . ' olympic', 'olympic.id = uo.olympiads_id')
            ->innerJoin(Diploma::tableName() . ' diploma', 'diploma.user_id = uo.user_is')
            ->andWhere(['uo.status' => UserOlimpiads::ACTIVE])
            ->andWhere(['utj.user_id' => \Yii::$app->user->identity->getId()])
            ->andWhere(['utj.school' => $school_id])
            ->orderBy(['olympic.year'=> SORT_DESC]);
    }
}