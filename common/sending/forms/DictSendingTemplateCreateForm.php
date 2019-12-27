<?php


namespace common\sending\forms;


use common\sending\models\DictSendingTemplate;
use common\sending\traits\DictSendingTemplateTrait;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DictSendingTemplateCreateForm extends Model
{
    use DictSendingTemplateTrait;

    public function rules(): array
    {
        $rules = [['type', 'unique', 'targetClass'=> DictSendingTemplate::class, 'targetAttribute' => ['type', 'type_sending'], 'message' => 'Такой шаблон  уже существует!']];
        return ArrayHelper::merge($rules, $this->validateRules());
    }
}