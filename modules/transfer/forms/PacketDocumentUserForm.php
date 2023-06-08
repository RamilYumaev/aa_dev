<?php


namespace modules\transfer\forms;
use modules\entrant\components\MaxDateValidate;
use modules\entrant\helpers\DateFormatHelper;
use modules\transfer\models\PacketDocumentUser;
use Yii;

/**
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $packet_document
 * @property string $number
 * @property string $authority
 * @property string $date
 * @property integer $type
 * @property string $note
**/

class PacketDocumentUserForm extends PacketDocumentUser
{
    public function rules()
    {
        return [
            [['number', 'authority', 'date'], 'required', 'when' => function($model) {
                return $model->packet_document !=  self::PACKET_DOCUMENT_BOOK; },],
            [['cause_id'], 'required', 'when' =>
                function($model) {
                    return $model->packet_document ==  self::PACKET_DOCUMENT_REMOVE; },
            ],
            [['note'], 'required', 'when' =>
                function($model) {
                    return $model->cause_id == 5; },
            ],
            [['date'], MaxDateValidate::class]
            ];
    }

    public function beforeSave($insert) {
        if($this->date){
            $this->date = DateFormatHelper::formatRecord($this->date);
        }
        return parent::beforeSave($insert);
    }
}