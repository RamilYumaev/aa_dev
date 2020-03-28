<?php


namespace modules\entrant\models;

use modules\entrant\forms\ECPForm;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "{{%ecp}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property string $file_name
 *
**/

class ECP extends ActiveRecord
{

    public $name_file;

    public static  function create(UploadedFile $file, $user_id) {
        $ecp =  new static();
        $ecp->setFile($file);
        $ecp->user_id = $user_id;
        return $ecp;
    }

    public function setFile(UploadedFile $file): void
    {
        $this->file_name = $file;
        $this->name_file = \Yii::$app->security->generateRandomString() . '_' . time();
    }


    public function attributeLabels()
    {
        return [
            'type'=>'Тип',
            'file_name'=>'Файл',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => FileUploadBehavior::class,
                'attribute' => 'file_name',
                'filePath' => '@frontendRoot/ecp/[[attribute_name_file]].[[extension]]',
                'fileUrl' => '@frontendInfo/ecp/[[attribute_name_file]].[[extension]]',
            ],
        ];
    }

}