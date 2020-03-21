<?php
namespace modules\dictionary\models;

use modules\entrant\models\dictionary\queries\DictIncomingDocumentTypeQuery;

class DictIncomingDocumentType extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%dict_incoming_document_type}}';
    }

    public static function find(): DictIncomingDocumentTypeQuery
    {
        return new DictIncomingDocumentTypeQuery(static::class);
    }


}