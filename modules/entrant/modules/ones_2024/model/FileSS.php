<?php

namespace modules\entrant\modules\ones_2024\model;
use modules\entrant\modules\ones\job\CompetitiveListJob;
use modules\entrant\modules\ones\model\CompetitiveList;
use modules\entrant\modules\ones_2024\job\ImportCgJob;
use modules\entrant\modules\ones_2024\job\ImportEntrantAppJob;
use modules\entrant\modules\ones_2024\job\ImportOriginalJob;
use modules\usecase\ImageUploadBehaviorYiiPhp;
use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * @property int $id
 * @property int $type
 * @property int $created_at
 *
 */

class FileSS extends ActiveRecord
{
    const FILE_STATEMENT = 1;
    const FILE_CG = 2;

    const FILE_UPDATE_PRIORITY = 3;

    const FILE_UPDATE_ORIGINAL = 4;

    public $check;

    public static function tableName(): string
    {
        return '{{%file_ss}}';
    }

    public function rules(): array
    {
        return [
            [['type'], 'integer'],
            ['file_name', 'file', 'extensions' => 'xlsx'],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if($this->file_name) {
            $queue = Yii::$app->queue;
            $queue->ttr(20000);
            $message = 'Задание отправлено в очередь';
            if($this->type == self::FILE_CG) {
                $queue->push(new ImportCgJob(['model'=>$this]));
            }

            if($this->type == self::FILE_STATEMENT) {
                $queue->push(new ImportEntrantAppJob(['model'=>$this]));
            }

            if($this->type == self::FILE_UPDATE_ORIGINAL) {
                $queue->push(new ImportOriginalJob(['model'=>$this]));
            }

//            if($this->type == self::FILE_UPDATE_PRIORITY) {
//                $queue->push(new ImportEntrantAppJob(['model'=>$this]));
//            }

            Yii::$app->session->setFlash("info", $message);
        }
    }

    public function beforeValidate(): bool
    {
        $this->created_at = time();
        if (parent::beforeValidate()) {
            $this->file_name = UploadedFile::getInstance($this, 'file_name');
            return true;
        }
        return true;
    }

    public function attributeLabels(): array
    {
        return [
            'type' => "Тип файла",
            'file_name'=>'Файл (Excel)',
        ];
    }
    public static function listStatuses()
    {
        return [
            self::FILE_CG => "Конкурсные группы",
            self::FILE_STATEMENT => " Абитуриенты и заявления",
            self::FILE_UPDATE_ORIGINAL => "Оригиналы",
            self::FILE_UPDATE_PRIORITY => " Абитуриенты, заявления, обновления приоритетов",
        ];
    }

    public function getStatusName() {
        return self::listStatuses()[$this->status];
    }

    public function behaviors()
    {
        return [
            [
                'class' => ImageUploadBehaviorYiiPhp::class,
                'attribute' => 'file_name',
                'filePath' => '@modules/entrant/files/ss_fok/[[attribute_id]]/[[attribute_file_name]]',
            ],
        ];
    }
}
