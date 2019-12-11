<?php


namespace common\sending\forms;


use common\sending\models\DictSendingTemplate;
use yii\base\Model;

class DictSendingTemplateForm extends Model
{

    public $name, $html, $text, $check_status, $base_type;

    public function __construct(DictSendingTemplate $dictSendingTemplate = null, $config = [])
    {
        if($dictSendingTemplate) {
            $this->name =$dictSendingTemplate->name;
            $this->text = $dictSendingTemplate->text;
            $this->html = $dictSendingTemplate->html;
            $this->check_status = $dictSendingTemplate->check_status;
            $this->base_type = $dictSendingTemplate->base_type;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'html', 'text'], 'required'],
            [['html', 'text'], 'string'],
            [['check_status', 'base_type'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return DictSendingTemplate::labels();
    }



}