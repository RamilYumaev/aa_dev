<?php


namespace modules\management\models;

use modules\dictionary\models\queries\DictIndividualAchievementCgQuery;
use modules\management\controllers\admin\TaskController;
use modules\management\models\queries\ManagementUserQuery;
use modules\management\models\queries\PostManagementQuery;
use olympic\models\auth\Profiles;
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

    public function getPostManagement()
    {
        return $this->hasOne(PostManagement::class, ['id' => 'post_management_id']);
    }

    public function getPostManagementDirector()
    {
        return $this->getPostManagement()->where(['is_director' => true]);
    }

    public function getManagementTask()
    {
        return $this->hasMany(ManagementTask::class, ['post_management_id' => 'post_management_id']);
    }

    public function getProfile()
    {
        return $this->hasOne(Profiles::class, ['user_id' => 'user_id']);
    }

    public static function find(): ManagementUserQuery
    {
        return new ManagementUserQuery(static::class);
    }
}