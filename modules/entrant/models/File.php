<?php


namespace modules\entrant\models;

use modules\entrant\models\queries\FileQuery;
use modules\usecase\ImageGD;
use modules\usecase\ImageUploadBehaviorYiiPhp;
use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%files}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $model
 * @property integer $record_id
 * @property string $file_name_user
 * @property string $file_name_base
 * @property integer $position
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

    public function setPosition($position)
    {
        $this->position = $position;
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

    public function getModelHash() {
        return  Yii::$app->getSecurity()->encryptByKey($this->record_id, $this->model);
    }


    public function behaviors()
    {
        return [
            [
                'class' => ImageUploadBehaviorYiiPhp::class,
                'attribute' => 'file_name_user',
                'thumbs' => [
                    'thumb' => ['processor' => function (ImageGD $thumb) {
                        return $thumb->resize(300, 500);
                    }],
                    'crop' => ['processor' => function (ImageGD $thumb) {
                        return $thumb->crop(800, 0, 550, 550);
                    }],
                ],
                'thumbPath' => '@frontend/file/[[attribute_user_id]]/[[profile]]_[[attribute_file_name_base]]_[[pk]].[[extension]]',
                'filePath' => '@frontend/file/[[attribute_user_id]]/[[attribute_file_name_base]].[[extension]]',
            ],
        ];
    }


    public static function find(): FileQuery
    {
        return new FileQuery(static::class);
    }

}