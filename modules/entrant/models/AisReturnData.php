<?php


namespace modules\entrant\models;

use modules\entrant\models\queries\FileQuery;
use modules\usecase\ImageGD;
use modules\usecase\ImageUploadBehaviorYiiPhp;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%ais_return_data}}".
 *
 * @property integer $id
 * @property integer $created_id
 * @property integer $incoming_id
 * @property string $model
 * @property integer $model_type
 * @property integer $record_id_sdo
 * @property integer $record_id_ais
 * @property integer $created_at;
 * @property integer $updated_at;
 *
**/

class AisReturnData extends ActiveRecord
{
    public static  function create($createdId, $model, $modelType, $incomingId, $recordIdSdo, $recordIdAis) {
        $returnData =  new static();
        $returnData->created_id = $createdId;
        $returnData->incoming_id = $incomingId;
        $returnData->model = $model;
        $returnData->model_type = $modelType;
        $returnData->record_id_sdo = $recordIdSdo;
        $returnData->record_id_ais = $recordIdAis;
        return $returnData;
    }

    public static function tableName()
    {
        return '{{%ais_return_data}}';
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
            TimestampBehavior::class,
        ];
    }


}