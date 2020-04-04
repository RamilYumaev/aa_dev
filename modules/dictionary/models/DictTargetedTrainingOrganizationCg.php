<?php


namespace modules\dictionary\models;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use yii2mod\moderation\ModerationBehavior;

/**
 * This is the model class for table "{{%dict_targeted_training_organization}}".
 *
 * @property integer $id
 * @property string $name
 *
 **/

class DictTargetedTrainingOrganization extends YiiActiveRecordAndModeration
{
    public function behaviors()
    {
        return ['moderation' => [
            'class'=> ModerationBehavior::class,
            'attributes'=>['name']
        ]];
    }

    public static function tableName()
    {
        return "{{%dict_targeted_training_organization}}";
    }

    public static function create($name) {
        $dict = new static();
        $dict->data($name);
        return $dict;
    }

    public function data($name) {
        $this->name = $name;
    }

    public function titleModeration(): string
    {
        return "Ораганизации целового обучение";
    }

    public function moderationAttributes($value): array
    {
        return ['name'=>$value];
    }
}