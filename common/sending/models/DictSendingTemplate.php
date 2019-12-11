<?php

namespace common\sending\models;

use common\sending\forms\DictSendingTemplateForm;
use Yii;
class DictSendingTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_sending_template';
    }

    public static function  create(DictSendingTemplateForm $form) {
        $template = new static();
        $template->name =$form->name;
        $template->text = $form->text;
        $template->html = $form->html;
        $template->check_status = $form->check_status;
        $template->base_type = $form->base_type;
        return $template;
    }

    public function edit(DictSendingTemplateForm $form) {

        $this->name =$form->name;
        $this->text = $form->text;
        $this->html = $form->html;
        $this->check_status = $form->check_status;
        $this->base_type = $form->base_type;

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название шаблона',
            'html' => 'Html-шаблон рассылки',
            'text' => 'Аналогичный текст рассылки',
            'check_status' => 'Проверен/Не проверен',
            'base_type' => 'Указать базовый тип шаблона',
        ];
    }


    public static function labels()
    {
        $template = new static();
        return $template->attributeLabels();
    }


}
