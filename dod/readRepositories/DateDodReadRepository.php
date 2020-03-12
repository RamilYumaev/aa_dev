<?php

namespace dod\readRepositories;

use dod\models\DateDod;

class DateDodReadRepository
{
    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord|null
     */

    public function find($id): ?DateDod
    {
        $model = DateDod::find()->dodDateIdOne($id);

        return  $model;
    }
}