<?php


namespace modules\transfer\forms;
use modules\entrant\components\MaxDateValidate;
use modules\transfer\models\PacketDocumentUser;

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
            [['note'], 'required', 'when' =>
                function($model) {
                    return $model->packet_document ==  self::PACKET_DOCUMENT_REMOVE; },
            ],
            [['date'], MaxDateValidate::class],
            [['date'], 'date', 'format' => 'd.m.Y'],
            ];
    }
}