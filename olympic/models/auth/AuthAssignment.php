<?php

namespace olympic\models\auth;


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

    public static function getRoleName($id)
    {
        $db = self::find()->select('item_name')->where(['user_id' => $id])->asArray()->all();
        if (!$db) {
            return [];
        }
        $roles = [];
        foreach ($db as $item) {
            $roles[$item['item_name']] = $item['item_name'];
        }
        return $roles;
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
