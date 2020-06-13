<?php

namespace modules\entrant\forms;

use modules\entrant\models\File;
use yii\base\Model;
use yii\web\UploadedFile;

class StatementMessageForm extends Model
{
    public $message;

    public function __construct(File $file, $config = [])
    {
        $this->setAttributes($file->getAttributes(), false);
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['message', 'string'],
            ['message', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
       return [ 'message'=> 'Сообщение'];
    }
}