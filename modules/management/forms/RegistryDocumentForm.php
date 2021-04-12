<?php

namespace modules\management\forms;

use modules\management\models\RegistryDocument;
use yii\base\Model;
use yii\web\UploadedFile;

class RegistryDocumentForm extends Model
{
    public $name, $link, $file, $access, $dict_department_id;
    public $registryDocument;
    public $category_document_id;
    public $user_id;

    public function __construct(RegistryDocument $registryDocument = null, $config = [])
    {
        if ($registryDocument) {
            $this->setAttributes($registryDocument->getAttributes(), false);
            $this->registryDocument = $registryDocument;
            $this->file = $registryDocument->file ?   $registryDocument->getUploadedFilePath('file') :
                $registryDocument->file;
        }else {
            $this->user_id =  \Yii::$app->user->identity->getId();
        }
        parent::__construct($config);
    }
    

    public function rules()
    {
        return [
            [['name','category_document_id', 'access'], 'required'],
            [['file'], 'required', 'when'=> function($model) {
                 if($model->registryDocument) {
                     return !$model->link && !$model->registryDocument->file;
                 }
                    return !$model->link;
            }, 'enableClientValidation' => false],
            [['dict_department_id'], 'required', 'when'=> function($model) {
                return $model->access == RegistryDocument::ACCESS_DEPARTMENT;
            }, 'enableClientValidation' => false],
            [['name', 'link'], 'string', 'max' => 255],
            [['access', 'dict_department_id'], 'integer'],
            [['name', 'link'],'trim'],
            ['file', 'file'],
            [['category_document_id'], 'integer'],
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->file = UploadedFile::getInstance($this, 'file');
            return true;
        }
        return false;
    }

    public function attributeLabels()
    {
        return (new RegistryDocument())->attributeLabels();
    }
}