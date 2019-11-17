<?php
namespace olympic\readRepositories;

use common\helpers\EduYearHelper;
use olympic\models\OlimpicList;
use olympic\models\UserOlimpiads;
use yii\db\ActiveRecord;

class UserOlympicReadRepository
{
    /**
     * @param $olympic_id
     * @param $user_id
     * @return array|\yii\db\ActiveRecord|null
     */

    public function find($olympic_id, $user_id): ?UserOlimpiads
    {
        $model = UserOlimpiads::findOne(['olympiads_id' => $olympic_id, 'user_id' => $user_id]);
        return  $model;
    }

    public function findAll($user_id)
    {
        $model = UserOlimpiads::find()->where(['user_id' => $user_id])->orderBy(['olympiads_id' => SORT_DESC ]);
        return  $model;
    }

    public function isEduYear($user_id)
    {
        return UserOlimpiads::find()->alias('uo')->
        innerJoin(OlimpicList::tableName() . ' ol', 'ol.id = uo.olympiads_id')
            ->where(['uo.user_id'=> $user_id])
            ->andWhere(['ol.year' => EduYearHelper::eduYear()])->exists();
    }

}