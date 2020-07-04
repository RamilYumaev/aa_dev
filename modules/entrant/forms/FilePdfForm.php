<?php

namespace modules\entrant\forms;

use modules\entrant\models\StatementAgreementContractCg;
use yii\base\Model;
use yii\web\UploadedFile;

class FilePdfForm extends Model
{
    public $file_name;

    private $_file;

    public function __construct(StatementAgreementContractCg $file = null, $config = [])
    {
        if($file){
            $this->setAttributes($file->getAttributes(), false);
            $this->_file = $file;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['file_name', 'file',
                'extensions' => 'pdf',
                'maxSize' => 1024 * 1024 * 10],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
       return [ 'file_name'=>'Файл PDF',];
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