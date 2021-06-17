<?php
namespace modules\dictionary\models\queries;

use modules\entrant\helpers\DateFormatHelper;
use yii\db\ActiveQuery;

class SettingCompetitionListQuery extends ActiveQuery
{
    public function dateStart() {
        return $this->andWhere(['<=', 'date_start',  date("Y-m-d")]);
    }

    public function dateEnd() {
        return $this->andWhere(['>=', 'date_end',  date("Y-m-d")]);
    }

    public function timeStart() {
        return $this->andWhere(['<', 'time_start',  date("H:i:s")]);
    }

    public function timeEnd() {
        return $this->andWhere(['>', 'time_end',  date("H:i:s")]);
    }

    public function timeStartWeek() {
        return $this->andWhere(['<', 'time_start_week',  date("H:i:s")]);
    }

    public function timeEndWeek() {
        return $this->andWhere(['>', 'time_end_week',  date("H:i:s")]);
    }

    public function dateIgnore($date) {
        return $this->andWhere(['not like', 'date_ignore' , $date]);
    }

    public function auto() {
        return $this->andWhere(['is_auto' => true]);
    }

    public function getAllWork($date)
    {
      $query = $this->auto()->dateIgnore($date)->dateStart()->dateEnd();
      if(DateFormatHelper::isWeekEnd($date)) {
          $query->timeStartWeek()->timeEndWeek();
      }else {
          $query->timeStart()->timeEnd();
      }
      return $query->all();
    }
}