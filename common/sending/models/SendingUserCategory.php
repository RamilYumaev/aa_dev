<?php

namespace common\sending\models;

use common\auth\models\User;
use Yii;

/**
 * This is the model class for table "sending_user_category".
 *
 * @property int $category_id
 * @property int $user_id
 *
 * @property DictSendingUserCategory $category
 * @property User $user
 */
class SendingUserCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sending_user_category';
    }

    public static function create($category_id, $user_id) {
        $userCat = new static();
        $userCat->category_id  =$category_id;
        $userCat->user_id = $user_id;
        return $userCat;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'user_id'], 'required'],
            [['category_id', 'user_id'], 'integer'],
            [['category_id', 'user_id'], 'unique', 'targetAttribute' => ['category_id', 'user_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictSendingUserCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'user_id' => 'User ID',
        ];
    }
}
