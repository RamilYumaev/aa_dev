<?php

namespace modules\management\searches;


use modules\management\models\DictTask;
use modules\management\models\ManagementUser;
use modules\management\models\Schedule;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ScheduleSearch extends Model
{
    public $user_id, $post, $isBlocked;

    public function rules()
    {
        return [
            [['user_id', 'isBlocked'], 'integer'],
            [['post'], 'safe'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Schedule::find()->alias('s');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!empty($this->post)) {
            $query->innerJoin(ManagementUser::tableName() . ' m', 'm.user_id = s.user_id');
            $query->andWhere(['m.post_rate_id' => $this->post]);
        }

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->filterWhere(['s.user_id'=> $this->user_id, 'isBlocked' => $this->isBlocked]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new DictTask())->attributeLabels();
    }

}