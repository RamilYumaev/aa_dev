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
 * @property integer $post_rate_id
 * @property integer $user_id
 * @property boolean $is_assistant
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
        $managementUser->post_rate_id = $postManagementId;
        $managementUser->user_id = $userId;
        return $managementUser;
    }

    public function setIsAssistant($value)
    {
        $this->is_assistant = $value;
    }

    public function getPostManagement()
    {
        return $this->hasOne(PostRateDepartment::class, ['id' => 'post_rate_id']);
    }

    public function getPostManagementDirector()
    {
        return $this->getPostManagement()->joinWith('postManagement')->where(['is_director' => true]);
    }

    public function getManagementTask()
    {
        return $this->hasMany(ManagementTask::class, ['post_rate_id' => 'post_rate_id']);
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