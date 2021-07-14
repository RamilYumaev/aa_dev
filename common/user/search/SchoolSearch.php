<?php

namespace common\user\search;

use dictionary\helpers\DictCountryHelper;
use dictionary\models\DictSchools;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SchoolSearch extends Model
{
    public $name,
        $region_id,
        $country_id;

    public function rules()
    {
        return [
            [['region_id', 'country_id'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = DictSchools::find()->orderBy(['name'=> SORT_ASC ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if($this->country_id != DictCountryHelper::RUSSIA) {
            $this->region_id = null;
        }

        $query->andFilterWhere([
            'country_id'=>$this->country_id,
            'region_id'=>$this->region_id,
        ]);


        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
       return DictSchools::labels();
    }

}