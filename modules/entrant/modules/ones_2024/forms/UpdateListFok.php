<?php

namespace modules\entrant\modules\ones_2024\forms;
use yii\base\Model;
use yii\web\UploadedFile;

class UpdateListFok extends Model
{
    public $file_name;
    public $id;

    public function rules(): array
    {
        return [
            ['id', 'integer'],
            ['file_name', 'file', 'extensions' => 'xlsx'],
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->file_name = UploadedFile::getInstance($this, 'file_name');
            return true;
        }
        return true;
    }

    public function attributeLabels(): array
    {
        return [
            'file_name'=>'Файл (Excel)',
        ];
    }
}
