<?php
namespace modules\entrant\models;


use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;

class Anketa extends YiiActiveRecordAndModeration
{
    public static function tableName()
    {
        return "{{%anketa}}";
    }

    public function behaviors()
    {
        return ['moderation' => [
            'class'=> ModerationBehavior::class,
            'attributes'=>['citizenship_id', 'edu_finish_year', 'current_edu_level', 'category_id']
        ]];
    }

    public function titleModeration(): string
    {
        return "Анкета";
    }

    public function moderationAttributes($value): array
    {
        return [
            'citizenship_id' => $value,
            'edu_finish_year' => $value,
            'current_edu_level'=> $value,
            'category_id'=> $value,
        ];
    }
}