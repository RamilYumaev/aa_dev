<?php

namespace modules\entrant\forms;

use modules\entrant\models\File;
use yii\base\Model;
use yii\web\UploadedFile;

class FileMessageForm extends Model
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
            ['message', 'string', 'max'=>255],
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