<?php

namespace modules\dictionary\helpers;
use modules\dictionary\models\DictOrganizations;
use modules\dictionary\models\DictTargetedTrainingOrganizationCg;
use yii\helpers\ArrayHelper;

class DictOrganizationsHelper
{
    public static function organizationList()
    {
        return ArrayHelper::map(DictOrganizations::find()->orderBy(['name'=> SORT_ASC])->all(), 'id', 'name');
    }

    public static function organizationName($key) {
       return ArrayHelper::getValue(self::organizationList(), $key);
    }
}