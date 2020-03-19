<?php

namespace modules\entrant\models;


use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;

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
}