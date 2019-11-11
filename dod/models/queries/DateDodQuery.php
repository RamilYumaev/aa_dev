<?php


namespace dod\models\queries;

use dod\models\Dod;

class DateDodQuery extends \yii\db\ActiveQuery
{
    /**
     * @param $type
     * @return array|\yii\db\ActiveRecord[]
     */

    public function dodTypeAll($type) {
        return $this->dodDateActual()
            ->andWhere(['dod.type' => $type])
            ->orderBy(['dod.edu_level' => SORT_DESC, 'dod_date.date_time' => SORT_ASC])
            ->all();
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord|null
     */

    public function dodDateIdOne($id)
    {
        return $this->dodDateActual()
               ->andWhere(['dod_date.id' => $id])
               ->one();
    }

    /**
     * @return DateDodQuery
     */

    private function dodDateActual() {
        return $this->alias('dod_date')
            ->innerJoin(Dod::tableName() . ' dod', 'dod.id = dod_date.dod_id')
            ->andWhere(['>', 'dod_date.date_time', date('Y-m-d H:i:s')]);
    }


}