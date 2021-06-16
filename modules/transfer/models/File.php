<?php


namespace modules\transfer\models;

use modules\entrant\helpers\FileHelper;
use modules\entrant\models\queries\FileQuery;
use modules\usecase\ImageGD;
use modules\usecase\ImageUploadBehaviorYiiPhp;
use olympic\models\auth\Profiles;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%files}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property string $model
 * @property integer $record_id
 * @property string $file_name_user
 * @property string $file_name_base
 * @property integer $position
 * @property integer $created_at;
 * @property integer $updated_at;
 * @property string $message;
 *
**/

class File extends ActiveRecord
{
    public $file_name;
    const UPDATE = 0;

    public static  function create(UploadedFile $files, $user_id, $model, $record_id) {
        $file =  new static();
        $file->user_id = $user_id;
        $file->model = $model;
        $file->record_id = $record_id;
        $file->setFile($files);
        return $file;
    }

    public function rules()
    {
        return [
            ['file_name', 'image',
                'minHeight' => 300,
                'extensions' => 'jpg, png, jpeg',
                'maxSize' => 1024 * 1024 * 10],
            ['message','required', 'on'=> self::UPDATE]
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->file_name = UploadedFile::getInstance($this, 'file_name');
            return true;
        }
        return false;
    }

    public static function tableName()
    {
        return '{{%files_transfer}}';
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }


    public function setStatus($status) {
        $this->status = $status;
    }

    public function isDraftStatus() {
        return  $this->status == FileHelper::STATUS_DRAFT;
    }

    public function getStatusName() {
        return  FileHelper::statusName($this->status);
    }

    public function isWaltStatus() {
      return  $this->status == FileHelper::STATUS_WALT;
    }

    public function isAcceptedStatus() {
        return  $this->status == FileHelper::STATUS_ACCEPTED;
    }

    public function isNoAcceptedStatus() {
        return  $this->status == FileHelper::STATUS_NO_ACCEPTED;
    }

    public function getProfileUser() {
        return $this->hasOne(Profiles::class, ['user_id' => 'user_id']);
    }

    public function getModelName() {
        return FileHelper::listName()[$this->model];
    }

    public function setFile(UploadedFile $file): void
    {
        $this->file_name_user = $file;
        $this->file_name_base= \Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function attributeLabels()
    {
        return [
            'user_id'=>'Абитуриент',
            'model'=>'Модель',
            'updated_at' => "Дата обновления",
            'status' => "Статус"
        ];
    }

    public function getModelHash() {
        return  Yii::$app->getSecurity()->encryptByKey($this->record_id, $this->model);
    }

    public function getHashId() {
        return  '#'.FileHelper::listHash()[$this->model].$this->record_id;
    }


    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => ImageUploadBehaviorYiiPhp::class,
                'attribute' => 'file_name_user',
//                'thumbs' => [
//                    'thumb' => ['processor' => function (ImageGD $thumb) {
//                        return $thumb->resize(500, 500);
//                    }],
//                    'crop' => ['processor' => function (ImageGD $thumb) {
//                        return $thumb->crop(800, 450, 400, 400);
//                    }],
//                ],
//              'thumbPath' => '@frontend/file/[[attribute_user_id]]/[[profile]]_[[attribute_file_name_base]]_[[pk]].[[extension]]',
                'filePath' => '@frontend/file_transfer/[[attribute_user_id]]/[[attribute_file_name_base]].[[extension]]',
            ],
        ];
    }


    public static function find(): FileQuery
    {
        return new FileQuery(static::class);
    }

}