<?php

namespace modules\superservice\models;

use Yii;

/**
 * This is the model class for table "ss_model_documents".
 *
 * @property int $id
 * @property int $id_type_document
 * @property int $id_type_document_version
 * @property int $record_id
 * @property string $model
 * @property int|null $additional
 * @property string|null $data_json
 */
class SsModelDocuments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ss_model_documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_type_document', 'id_type_document_version', 'record_id', 'model'], 'required'],
            [['id_type_document', 'id_type_document_version', 'record_id', 'additional'], 'integer'],
            [['data_json'], 'safe'],
            [['model'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_type_document' => 'Id Type Document',
            'id_type_document_version' => 'Id Type Document Version',
            'record_id' => 'Record ID',
            'model' => 'Model',
            'additional' => 'Additional',
            'data_json' => 'Data Json',
        ];
    }
}
