<?php

namespace modules\entrant\forms;

use modules\entrant\models\File;
use yii\base\Model;
use yii\web\UploadedFile;

class FileForm extends Model
{
    public $file_name, $user_id;

    private $_File;

    public function __construct(File $File = null, $config = [])
    {
        if($File){
            $this->setAttributes($File->getAttributes(), false);
            $this->_File = $File;
        }
        $this->user_id = \Yii::$app->user->identity->getId();
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['file_name', 'file'],
        ];
    }
    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
        return (new File())->attributeLabels();
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