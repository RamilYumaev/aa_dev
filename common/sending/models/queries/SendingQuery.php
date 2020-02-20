<?php

namespace common\sending\models\queries;

class SendingQuery extends \yii\db\ActiveQuery
{
    /**
     * @return $this
     */

    public function orderByStatusDeadlineAsc()
    {
        return $this->orderBy(['status_id' => SORT_ASC, 'deadline' => SORT_ASC]);
    }

    public function type($type)
    {
        return $this->andWhere(['type_id'=>$type]);
    }

    public function value($value)
    {
        return $this->andWhere(['value'=>$value]);
    }

    public function typeSending($type)
    {
        return $this->andWhere(['type_sending'=>$type]);
    }

    public function statusSending($status)
    {
        return $this->andWhere(['status_id'=>$status]);
    }


}