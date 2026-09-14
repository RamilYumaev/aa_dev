<?php
namespace modules\transfer\search;

use modules\transfer\models\TransferSetting;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TransferSettingSearch extends TransferSetting
{
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['finances', 'citizenship', 'semesters'], 'safe'],
            [['date_start', 'date_end'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = TransferSetting::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'finances', $this->finances])
            ->andFilterWhere(['like', 'citizenship', $this->citizenship])
            ->andFilterWhere(['like', 'semesters', $this->semesters]);

        if ($this->date_start) {
            $query->andWhere(['>=', 'date_start', $this->date_start]);
        }

        if ($this->date_end) {
            $query->andWhere(['<=', 'date_end', $this->date_end]);
        }

        return $dataProvider;
    }
}
