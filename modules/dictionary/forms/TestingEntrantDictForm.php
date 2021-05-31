<?php

namespace modules\dictionary\forms;

use modules\dictionary\models\TestingEntrantDict;
use yii\base\Model;

class TestingEntrantDictForm extends Model
{
    public $message;
    public $images;

    public function __construct(TestingEntrantDict $testingEntrantDict, $config = [])
    {
        $this->message = $testingEntrantDict->error_note;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['message', 'string'],
            [['images'], 'image', 'extensions' => 'jpg', 'maxFiles' => 5],
            ['message', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
       return [ 'message'=> 'Сообщение об ошибке', 'images' => 'Скриншоты'];
    }
}