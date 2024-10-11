<?php
namespace olympic\forms\search;

use olympic\models\OlympicSpecialityProfile;
use yii\data\ActiveDataProvider;

/**
 * @property string $name
 * @property string $olympic_speciality_id
 */
class OlympicSpecialityProfileSearch extends OlympicSpecialityProfile
{
    public function rules()
    {
        return [
            [['name', 'olympic_speciality_id'], 'safe'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'olympic_speciality_id' => $this->olympic_speciality_id,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
