<?php


namespace modules\management\models;

use modules\dictionary\models\queries\DictIndividualAchievementCgQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%management_user}}".
 *
 * @property integer $post_management_id
 * @property integer $user_id
 **/

class ManagementUser extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%management_user}}";
    }

    public static function create($postManagementId, $userId)
    {
        $managementUser = new static();
        $managementUser->post_management_id = $postManagementId;
        $managementUser->user_id = $userId;

        return $managementUser;
    }
}