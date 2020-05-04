<?php


namespace modules\entrant\models;

use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "{{%files}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $model
 * @property integer $record_id
 * @property string $file_name_user
 * @property string $file_name_base
 *
**/

class File extends ActiveRecord
{
    public static  function create(UploadedFile $files, $user_id, $model, $record_id) {
        $file =  new static();
        $file->user_id = $user_id;
        $file->model = $model;
        $file->record_id = $record_id;
        $file->setFile($files);
        return $file;
    }

    public static function tableName()
    {
        return '{{%files}}';
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
                'filePath' => '@frontend/file/[[attribute_user_id]]/[[attribute_file_name_base]].[[extension]]',
            ],
        ];
    }

}