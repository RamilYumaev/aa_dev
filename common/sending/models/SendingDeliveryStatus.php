<?php

namespace common\sending\models;;

use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\models\queries\SendingDeliveryStatusQuery;
use Yii;

/**
 * This is the model class for table "sending_delivery_status".
 *
 * @property int $sending_id
 * @property int $user_id
 * @property string $hash
 * @property string $from_email
 * @property int $status_id 0 - ожидание ответа, 1 - прочитано
 * @property int $type_sending 1- приглашение, 2 - дипломы, 3 - подтверждение
 * @property int $type 1- Олимпиада, 2 - ДОД 3 -МК
 * @property int $value int
 * @property string $delivery_date_time
 *
 */
class SendingDeliveryStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'sending_delivery_status';
    }

    public static function create($sending_id, $user_id, $hash, $type, $type_sending, $value, $email_from) {
        $delivery = new static();
        $delivery->sending_id =$sending_id;
        $delivery->user_id = $user_id;
        $delivery->hash = $hash;
        $delivery->status_id = SendingDeliveryStatusHelper::STATUS_SEND;
        $delivery->type = $type;
        $delivery->from_email = $email_from;
        $delivery->type_sending = $type_sending;
        $delivery->value = $value;
        $delivery->delivery_date_time = date("Y-m-d H:i:s");
        return $delivery;
    }

    public function setStatus($status) {
        $this->status_id = $status;
    }

    public function isStatusRead() {
        return $this->status_id == SendingDeliveryStatusHelper::STATUS_READ;
    }

    public static function find(): SendingDeliveryStatusQuery
    {
        return new SendingDeliveryStatusQuery(static::class);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sending_id' => 'Название рассылки',
            'user_id' => 'Получатель письма',
            'status_id' => 'Статус доставки',
        ];
    }
}
