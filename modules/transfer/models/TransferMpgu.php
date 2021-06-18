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
use yii\db\Exception;

/**
 * This is the model class for table "{{%transfer_mpgu}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $current_status
 * @property string $data_mpgsu
 * @property integer $type
 * @property string $number
**/

class TransferMpgu extends ActiveRecord
{
    const IN_MPGU = 1;
    const IN_INSIDE_MPGU = 2;
    const INSIDE_MPGU = 3;
    const FROM_EDU = 4;
    /* mphu */
    const STATUS_ACTIVE = 1;
    const STATUS_EXPELLED = 7;

    const STATUS_ACADEMIC_LEAVE = 2;
    const STATUS_REMOVE = 3;
    const STATUS_EXTENDED_DEADLINE = 4;
    const STATUS_SENT_WORD = 5;
    const STATUS_END_EDU = 9;
    const STATUS_VACATION = 10;
    const STATUS_EXPELLED_NO_RIGHT = 11;
    const STATUS_VACATION_WORK = 12;
    const STATUS_TRANSFER_EXAM = 13;

    const ACTIVE = [self::STATUS_ACTIVE, self::STATUS_EXPELLED];

    public static function tableName()
    {
        return '{{%transfer_mpgu}}';
    }

    public function rules()
    {
        return [
            [['type', 'user_id'],'required'],
            [['number'],'string',  'min'=> 4,'max' => 10],
            [['number'], 'required', 'when'=> function($model) {
                return $model->type != self::FROM_EDU;
            }, 'enableClientValidation' => false],
            ['type','in','range'=> [self::FROM_EDU, self::IN_INSIDE_MPGU, self::IN_MPGU, self::INSIDE_MPGU]]
        ];
    }

    public function listType() {
        return [
            self::IN_MPGU => 'Восстановление внутри МПГУ',
            self::IN_INSIDE_MPGU => 'Восстановление с переводом внутри МПГУ',
            self::INSIDE_MPGU => 'Перевод внутри МПГУ',
            self::FROM_EDU => 'Перевод из другой образовательной организации',
        ];
    }

    public function listMessage() {
        return [
            self::STATUS_ACADEMIC_LEAVE => 'Вам недоступна процедура перевода/восстановления. Необходимо обратиться в дирекцию факультета/института',
            self::STATUS_VACATION => 'Вам недоступна процедура перевода/восстановления.',
            self::STATUS_EXTENDED_DEADLINE => 'Вам недоступна процедура перевода/восстановления.',
            self::STATUS_SENT_WORD => 'Вам недоступна процедура перевода/восстановления.',
            self::STATUS_EXPELLED_NO_RIGHT => 'Вам недоступна процедура перевода/восстановления.',
            self::STATUS_END_EDU => 'Вам недоступна процедура перевода/восстановления.',
            self::STATUS_REMOVE => 'Вам недоступна процедура перевода/восстановления.',
            self::STATUS_VACATION_WORK => 'Вам недоступна процедура перевода/восстановления.',
            self::STATUS_TRANSFER_EXAM => 'Вам недоступна процедура перевода/восстановления.',
        ];
    }

    public function isMpgu()  {
        return $this->type == TransferMpgu::IN_MPGU ||
            $this->type == TransferMpgu::IN_INSIDE_MPGU  ||
            $this->type == TransferMpgu::INSIDE_MPGU;
    }

    public function inMpgu()  {
        return $this->type == TransferMpgu::IN_MPGU;
    }

    public function typeName() {
        return $this->listType()[$this->type];
    }

    public function getProfile() {
        return $this->hasOne(Profiles::class,['user_id'=> 'user_id']);
    }

    public function isStatusMpsuCorrectType() {
        if($this->current_status  == self::STATUS_ACTIVE) {
            if(!in_array($this->type,[self::INSIDE_MPGU])){
                throw new Exception('Вы можете выбрать только "Перевод внутри МПГУ"');
            }
        }elseif($this->current_status  == self::STATUS_EXPELLED) {
            if(!in_array($this->type,[self::IN_INSIDE_MPGU, self::IN_MPGU])){
                throw new Exception('Вы можете выбрать только "Восстановление внутри МПГУ" или 
                "Восстановление с переводом внутри МПГУ');
            }
        }

    }

    public function attributeLabels()
    {
        return [
            'current_status' =>"Статус",
            'type' => "Условие перевода/восстановления",
            'user_id' => 'Юзер',
            'number' => '№ студенческой зачетки',
        ];
    }
}