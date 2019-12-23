<?php

namespace common\auth\forms;

use common\auth\models\SettingEmail;
use common\auth\traits\SettingEmailTrait;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class SettingEmailCreateForm extends Model
{
    use SettingEmailTrait;

    public function rules(): array
    {
        $rules = [['user_id', 'unique', 'targetClass'=> SettingEmail::class]];
        return ArrayHelper::merge($rules, $this->validateRules());
    }

}