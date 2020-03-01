<?php
namespace modules\entrant\models\dictionary\queries;

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

}