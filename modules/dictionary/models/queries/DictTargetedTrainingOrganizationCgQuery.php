<?php


namespace modules\dictionary\models\queries;


use yii\db\ActiveQuery;

class DictTargetedTrainingOrganizationCgQuery extends ActiveQuery
{
    /**
     * @param  $targetedOrganizationId
     * @return $this
     */

    public function targetedOrganizationId($targetedOrganizationId)
    {
        return $this->andWhere(['targeted_organization_id' => $targetedOrganizationId]);
    }

}