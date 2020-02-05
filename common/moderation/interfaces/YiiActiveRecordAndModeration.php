<?php


namespace common\moderation\interfaces;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

abstract class YiiActiveRecordAndModeration extends ActiveRecord
{
    public abstract function titleModeration(): string;

    public abstract function moderationAttributes($value) :array;

    public function moderationValue($key, $value): ? string
    {
        return ArrayHelper::getValue($this->moderationAttributes($value), $key);
    }

}