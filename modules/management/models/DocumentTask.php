<?php

namespace modules\management\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%document_task}}".
 *
 * @property integer $task_id
 * @property integer $document_registry_id
 **/

class DocumentTask extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%document_task}}';
    }


    public static function create($doc, $task_id)
    {
        $document = new static();
        $document->document_registry_id = $doc;
        $document->task_id = $task_id;
        return $document;
    }

    public function getRegistryDocument() {
        return $this->hasOne(RegistryDocument::class, ['id' => 'document_registry_id']);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Задача',
            'registry_document_id' => 'Документ'
        ];
    }

}