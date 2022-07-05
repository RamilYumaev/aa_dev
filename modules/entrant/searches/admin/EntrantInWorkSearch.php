<?php

namespace modules\entrant\searches\admin;

use modules\entrant\models\EntrantInWork;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class EntrantInWorkSearch extends Model
{
    public $job_entrant_id;
    public $user_id;

    public function rules()
    {
        return [
            ['job_entrant_id', 'integer'],
            ['user_id', 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = EntrantInWork::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if ($this->user_id) {
            $data = explode(" ", $this->user_id);
            $query->joinWith('profile');

                if (key_exists(0, $data)) {
                    $query->orWhere(['like', 'last_name', $data[0]]);
                }
                if (key_exists(1, $data)) {
                    $query->orWhere(['like', 'first_name', $data[1]]);
                }
                if (key_exists(2, $data)) {
                    $query->orWhere(['like', 'patronymic', $data[2]]);
                }
        }

        $query->andFilterWhere(['job_entrant_id' => $this->job_entrant_id]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new EntrantInWork())->getAttributeLabels();
    }
}