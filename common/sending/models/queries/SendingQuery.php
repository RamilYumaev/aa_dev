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

}