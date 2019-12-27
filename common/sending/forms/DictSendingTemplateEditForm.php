<?php

namespace common\sending\forms;
use common\sending\models\DictSendingTemplate;
use common\sending\traits\DictSendingTemplateTrait;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DictSendingTemplateEditForm extends Model
{
    use DictSendingTemplateTrait;
    private  $dictSendingTemplate;

    public function __construct(DictSendingTemplate $dictSendingTemplate, $config = [])
    {
        $this->name =$dictSendingTemplate->name;
        $this->text = $dictSendingTemplate->text;
        $this->html = $dictSendingTemplate->html;
        $this->check_status = $dictSendingTemplate->check_status;
        $this->base_type = $dictSendingTemplate->base_type;
        $this->type = $dictSendingTemplate->type;
        $this->type_sending = $dictSendingTemplate->type_sending;
        $this->dictSendingTemplate = $dictSendingTemplate;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        $rules = [['type', 'unique', 'targetClass'=> DictSendingTemplate::class,  'filter'=>['<>', 'id', $this->dictSendingTemplate->id],  'targetAttribute' => ['type', 'type_sending'], 'message' => 'Такой шаблон  уже существует!']];
        return ArrayHelper::merge($rules, $this->validateRules());
    }
}