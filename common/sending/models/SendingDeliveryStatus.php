<?php

namespace common\sending\models;;

use Yii;
use app\models\User;

/**
 * This is the model class for table "sending_delivery_status".
 *
 * @property int $sending_id
 * @property int $user_id
 * @property int $status_id 0 - ожидание ответа, 1 - прочитано
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

    public static function create($sending_id, $user_id, $status_id, $hash) {
        $delivery = new static();
        $delivery->sending_id =$sending_id;
        $delivery->user_id = $user_id;
        $delivery->hash = $hash;
        $delivery->status_id = $status_id;
        return $delivery;
    }

    public function setStatus($status) {
        $this->status_id = $status;
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
