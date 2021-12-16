<?php

namespace modules\transfer\forms;

use modules\entrant\models\StatementAgreementContractCg;
use yii\base\Model;
use yii\db\BaseActiveRecord;
use yii\web\UploadedFile;

class FilePdfForm extends Model
{
    public $file_name;
    public $text;
    private $_file;

    const NUMBER = 'number';

    public function __construct(BaseActiveRecord $file = null, $config = [])
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
            ['text', 'required', 'on'=> self::NUMBER],
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
       return [ 'file_name'=>'Файл PDF', 'text'=> "Номер договора"];
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