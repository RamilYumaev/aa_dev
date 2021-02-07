<?php

namespace modules\management\models\queries;

use yii\db\ActiveQuery;

/**
 * @property $name string
 * @property $color string
 * @property $id integer
 */
class DictTaskQuery extends ActiveQuery
{
    /**
     * @return array
     */
    public function allColumn(): array
    {
        return $this->select(['name'])->indexBy('id')->column();
    }

}