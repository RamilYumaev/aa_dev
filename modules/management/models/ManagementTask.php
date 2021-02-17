<?php


namespace modules\management\models;

use modules\dictionary\models\queries\DictIndividualAchievementCgQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%management_task}}".
 *
 * @property integer $post_rate_id
 * @property integer $dict_task_id
 **/

class ManagementTask extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%management_task}}";
    }

    public static function create($postRateId, $dictTaskId)
    {
        $managementTask = new static();
        $managementTask->post_rate_id = $postRateId;
        $managementTask->dict_task_id = $dictTaskId;

        return $managementTask;
    }
}