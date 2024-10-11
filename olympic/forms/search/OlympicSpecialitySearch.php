<?php
namespace olympic\forms\search;

use olympic\models\OlympicSpeciality;
use yii\data\ActiveDataProvider;

/**
 * @property string $name
 */

class OlympicSpecialitySearch extends OlympicSpeciality
{

    public function rules()
    {
        return [
            [['name',], 'safe'],
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

        $query
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}