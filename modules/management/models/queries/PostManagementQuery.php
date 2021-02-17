<?php

namespace modules\management\models\queries;

use yii\db\ActiveQuery;

/**
 */
class PostManagementQuery extends ActiveQuery
{
    /**
     * @return array
     */
    public function allColumn(): array
    {
        return $this->select(['name'])->indexBy('id')->column();
    }

}