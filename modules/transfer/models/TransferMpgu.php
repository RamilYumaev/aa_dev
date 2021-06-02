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
 * @property integer $current_status
 * @property integer $type
 * @property string $number
**/

class TransferMpgu extends ActiveRecord
{
    const IN_MPGU = 1;
    const FROM_EDU = 2;
    public function rules()
    {
        return [
            [['type', 'user_id'],'required'],
            ['type','in','range'=> [self::FROM_EDU, self::IN_MPGU]]
        ];
    }

    public function listType() {
        return [
            self::IN_MPGU => 'Восстановление и/или перевод внутри МПГУ',
            self::FROM_EDU => 'Перевод из другой образовательной организации',
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