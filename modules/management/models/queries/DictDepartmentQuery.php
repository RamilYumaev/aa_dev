<?php

namespace modules\management\models\queries;

use yii\db\ActiveQuery;

/**
 */
class DictDepartmentQuery extends ActiveQuery
{
    /**
     * @return array
     */
    public function allColumn(): array
    {
        return $this->select(['name'])->indexBy('id')->column();
    }

}