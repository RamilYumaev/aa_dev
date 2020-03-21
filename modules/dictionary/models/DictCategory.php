<?php

namespace modules\dictionary\models;


use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use modules\dictionary\forms\DictCategoryForm;

/**
 * Class DictCategory
 * @package modules\entrant\models
 * @property string $name
 * @property integer $foreigner_status
 */
class DictCategory extends YiiActiveRecordAndModeration
{

    public function behaviors()
    {
        return ['moderation' => [
            'class' => ModerationBehavior::class,
            'attributes' => ['name', 'foreigner_status']
        ]];
    }

    public static function tableName()
    {
        return "{{%dict_category}}";
    }

    public static function create(DictCategoryForm $form)
    {
        $dictCategory = new static();
        $dictCategory->data($form);
        return $dictCategory;
    }

    public function data(DictCategoryForm $form)
    {
        $this->name = $form->name;
        $this->foreigner_status = $form->foreigner_status;
    }

    public function titleModeration(): string
    {
        return "Категории граждан";
    }

    public function moderationAttributes($value): array
    {
        return [
            'name' => $value,
            'foreigner_status' => $value,
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название категории',
            'foreigner_status' => 'Иностранные граждане',
        ];
    }

    public static function getList()
    {
        return self::find()->select("name")->indexBy("id")->column();
    }
}