<?php


namespace common\sending\forms;


use common\sending\models\DictSendingUserCategory;
use common\sending\traits\DictSendingUserCategoryTrait;
use yii\base\Model;

class DictSendingUserCategoryCreateForm extends Model
{
    use DictSendingUserCategoryTrait;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'unique', 'targetClass' => DictSendingUserCategory::class,  'message' => 'Название категории должно быть уникальным'],
            [['name'], 'string', 'max' => 255],
        ];
    }

}