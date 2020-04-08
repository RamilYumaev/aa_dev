<?php


namespace modules\entrant\models;

use modules\entrant\helpers\PostDocumentHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%submitted_documents}}".
 *
 * @property integer $user_id
 * @property integer $type
 * @property integer $status
 * @property string $date
 *
**/

class SubmittedDocuments extends ActiveRecord
{

    public static function create($type, $user_id) {
        $model = new static();
        $model->data($type, $user_id);
        return $model;
    }
    public function data($type, $user_id)
    {
        $this->type = $type;
        $this->user_id = $user_id;
        $this->status = 1;
    }

    public static function tableName()
    {
        return "{{%submitted_documents}}";
    }

    public function attributeLabels()
    {
        return [
            'type'=>'Способ подачи',
        ];
    }

    public function getTypeName() {
        return PostDocumentHelper::value(PostDocumentHelper::submittedList(), $this->type);
    }

}