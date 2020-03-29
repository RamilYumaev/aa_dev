<?php


namespace modules\entrant\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "{{%ecp}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property string $file_name_user
 * @property string $file_name_base
 *
**/

class ECP extends ActiveRecord
{

    public static  function create(UploadedFile $file, $user_id) {
        $ecp =  new static();
        $ecp->user_id = $user_id;
        $ecp->setFile($file);
        return $ecp;
    }

    public function setFile(UploadedFile $file): void
    {
        $this->file_name_user = $file;
        $this->file_name_base= \Yii::$app->security->generateRandomString() . '_' . time();
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
                'attribute' => 'file_name_user',
                'filePath' => '@frontendRoot/ecp/[[attribute_file_name_base]].[[extension]]',
                'fileUrl' => '@frontendInfo/ecp/[[attribute_file_name_base]].[[extension]]',
            ],
        ];
    }

}