<?php


namespace modules\dictionary\models;



use common\moderation\interfaces\YiiActiveRecordAndModeration;

class DictOrganizations extends YiiActiveRecordAndModeration
{

    public static function tableName()
    {
        return "{{dict_organizations}}";
    }

    public function titleModeration(): string
    {
        return "Целевые организации";
    }

    public function moderationAttributes($value): array
    {
        return [
            "name" => $value,
        ];
    }
}