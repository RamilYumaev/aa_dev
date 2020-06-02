<?php

namespace modules\entrant\forms;

use modules\entrant\models\File;
use yii\base\Model;
use yii\web\UploadedFile;

class FileForm extends Model
{
    public $file_name, $user_id;

    private $_file;

    public function __construct($user_id, File $file = null, $config = [])
    {
        if($file){
            $this->setAttributes($file->getAttributes(), false);
            $this->_file = $file;
        }
        $this->user_id = $user_id;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['file_name', 'image',
                'minHeight' => 300,
                'extensions' => 'jpg, png',
                'maxSize' => 1024 * 1024 * 5],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
       return [ 'file_name'=>'Файл',];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->file_name = UploadedFile::getInstance($this, 'file_name');
            return true;
        }
        return false;
    }
}