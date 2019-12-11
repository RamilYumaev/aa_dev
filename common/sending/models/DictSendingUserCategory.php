<?php

namespace common\sending\models;

use common\sending\forms\DictSendingUserCategoryCreateForm;
use common\sending\forms\DictSendingUserCategoryEditForm;
use Yii;

class DictSendingUserCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function create (DictSendingUserCategoryCreateForm $form) {
        $dictSendingUser = new static();
        $dictSendingUser->name = $form->name;
        return $dictSendingUser;
    }

    public function edit (DictSendingUserCategoryEditForm $form) {
        $this->name = $form->name;
    }


    public static function tableName()
    {
        return 'dict_sending_user_category';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название категории',
        ];
    }

    public static function labels(): array
    {
        $dictSendingUser = new static();
        return $dictSendingUser->attributeLabels();
    }

    public static function getAllCategoriesName()
    {
        return DictSendingUserCategory::find()->select('name')->indexBy('id')->column();
    }
}
