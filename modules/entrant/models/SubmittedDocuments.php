<?php


namespace modules\entrant\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%submitted_documents}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 *
**/

class SubmittedDocuments extends ActiveRecord
{
    public function data($type, $user_id)
    {
        $this->type = $type;
        $this->user_id = $user_id;
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

}