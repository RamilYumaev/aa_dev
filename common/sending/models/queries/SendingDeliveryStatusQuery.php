<?php


namespace common\sending\models\queries;


class SendingDeliveryStatusQuery extends \yii\db\ActiveQuery
{
    /**
     * @return $this
     */
    public function type($type)
    {
        return $this->andWhere(['type'=>$type]);
    }

    public function value($value)
    {
        return $this->andWhere(['value'=>$value]);
    }

    public function user($user)
    {
        return $this->andWhere(['user_id'=>$user]);
    }

    public function typeSending($type)
    {
        return $this->andWhere(['type_sending'=>$type]);
    }

    public function hash($hash)
    {
        return $this->andWhere(['hash'=>$hash]);
    }




}