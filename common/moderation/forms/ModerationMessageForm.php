<?php
namespace common\moderation\forms;

use yii\base\Model;

class ModerationMessageForm extends Model
{
    public $message;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'required'],
            [['message'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'message' => "Причина отклонения"
        ];
    }


}