<?php

namespace modules\management\models\queries;

use yii\db\ActiveQuery;

class PostRateDepartmentQuery extends ActiveQuery
{
    /**
     * @return array
     */

    public function getAllColumn($name = "name"): array
    {
        $array = [];
        foreach ($this->all() as $item) {
            $array[$item->id] = $item->postManagement->{$name} .'/ '. $item->rateName. ($item->dictDepartment ? '/ '.$item->dictDepartment->{$name} : '');

        }
        return $array;
    }



    /**
     * @return array
     */
    public function getAllColumnUser($userId): array
    {
        $array = [];
        foreach ($this->joinWith('managementUser')->where(['user_id'=>$userId])->all() as $item) {
            $array[$item->id] = $item->postManagement->name_short .'/ '. $item->rateName. ($item->dictDepartment ? '/ '.$item->dictDepartment->name_short : '');

        }
        return $array;
    }

    /**
     * @return array
     */
    public function getAllColumnShortUser($userId): array
    {
        $array = [];
        foreach ($this->joinWith('managementUser')->where(['user_id'=>$userId])->all() as $item) {
            $array[$item->id] = $item->postManagement->name_short;

        }
        return $array;
    }
}