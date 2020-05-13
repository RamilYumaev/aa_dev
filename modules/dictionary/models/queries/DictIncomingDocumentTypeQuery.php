<?php
namespace modules\dictionary\models\queries;

class DictIncomingDocumentTypeQuery extends \yii\db\ActiveQuery
{
    /**
     * @param  $type
     * @return $this
     */

    public function type($type)
    {
        return $this->andWhere(['type_id' => $type]);
    }

    /**
     * @param  $ids
     * @return $this
     */

    public function ids($ids)
    {
        return $this->andWhere(['id' => $ids]);
    }

}