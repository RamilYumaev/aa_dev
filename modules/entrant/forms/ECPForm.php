<?php

namespace modules\entrant\forms;

use modules\entrant\models\ECP;
use yii\base\Model;
use yii\web\UploadedFile;

class ECPForm extends Model
{
    public $file_name, $user_id;

    private $_ECP;

    public function __construct(ECP $ECP = null, $config = [])
    {
        if($ECP){
            $this->setAttributes($ECP->getAttributes(), false);
            $this->_ECP = $ECP;
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
        return (new ECP())->attributeLabels();
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