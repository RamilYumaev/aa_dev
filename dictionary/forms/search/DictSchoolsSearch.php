<?php
namespace dictionary\forms\search;

use dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictRegionHelper;
use dictionary\models\DictSchools;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DictSchoolsSearch extends Model
{
    public $country_id;
    public $region_id;
    public $name;

    public function rules(): array
    {
        return [
            [['country_id', 'region_id'], 'integer'],
            [['name',], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = DictSchools::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'country_id' => $this->country_id,
            'region_id' => $this->region_id,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function attributeLabels(): array
    {
        return DictSchools::labels();
    }

    public function regionList(): array
    {
        return DictRegionHelper::regionList();
    }

    public function countryList(): array
    {
        return DictCountryHelper::countryList();
    }

}