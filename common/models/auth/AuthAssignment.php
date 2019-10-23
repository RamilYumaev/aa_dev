<?php

namespace common\models\auth;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property int $created_at
 */
class AuthAssignment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    public static function create($role, $user_id)
    {
        $item = new static();
        $item->user_id = $user_id;
        $item->item_name = $role;
        $item->created_at = time();
        return $item;
    }

    public function isRoleUser($role): bool
    {
        return $this->item_name == $role;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_name' => 'Item Name',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }
}
