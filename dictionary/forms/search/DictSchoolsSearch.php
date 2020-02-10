<?php

namespace dictionary\forms\search;

use dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictRegionHelper;
use dictionary\helpers\DictSchoolsReportHelper;
use dictionary\models\DictSchools;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\QueryInterface;

class DictSchoolsSearch extends Model
{
    public $country_id;
    public $region_id;
    public $dict_school_report_id;
    public $name;
    protected $query;

    public function rules(): array
    {
        return [
            [['country_id', 'region_id', 'dict_school_report_id'], 'integer'],
            [['name',], 'safe'],
        ];
    }

    public function __construct(QueryInterface $query =null, $config = [])
    {
        if ($query) {
            $this->query = $query;
        }else {
            $this->query = DictSchools::find();
        }


        parent::__construct($config);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = $this->query;

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
            'dict_school_report_id' => $this->dict_school_report_id
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

    public function schoolReportList(): array
    {
        return DictSchoolsReportHelper::schoolReportList();
    }

    public function countryList(): array
    {
        return DictCountryHelper::countryList();
    }

}