<?php

namespace modules\management\models\queries;

use modules\management\models\ManagementUser;
use yii\db\ActiveQuery;

class CategoryDocumentQuery extends ActiveQuery
{
    /**
     * @return array
     */
    public function allColumn(): array
    {
        return $this->select('name')->indexBy('id')->column();
    }
}