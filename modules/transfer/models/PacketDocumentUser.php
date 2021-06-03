<?php


namespace modules\transfer\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCountryHelper;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\forms\AddressForm;
use modules\entrant\helpers\AddressHelper;
use olympic\models\auth\Profiles;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%transfer_mpgu}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $packet_document_user
**/

class PacketDocumentUser extends ActiveRecord
{
    const PACKET_DOCUMENT_EDU = 1;
    const PACKET_DOCUMENT_BOOK = 2;
    const PACKET_DOCUMENT_REMOVE = 3;

    public static function tableName()
    {
        return '{{%packet_document_user}}';
    }


    public function listType() {
        return [

            self::PACKET_DOCUMENT_EDU => 'скан-копия справки об обучении',
            self::PACKET_DOCUMENT_BOOK => 'Восстановление или восстановление с переводом внутри МПГУ',
            self::PACKET_DOCUMENT_REMOVE => 'Перевод из другой образовательной организации',
        ];
    }

    public function typeName() {
        return $this->listType()[$this->type];
    }

    public function getProfile() {
        return $this->hasOne(Profiles::class,['user_id'=> 'user_id']);
    }

    public function attributeLabels()
    {
        return [
            'current_status' =>"Статус",
            'type' => "Условия перевода/восстановления",
            'user_id' => 'Юзер',
            'number' => 'Уникальный номер',
        ];
    }
}