<?php

namespace modules\dictionary\searches;


use modules\dictionary\models\DictOrganizations;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DictOrganizationsSearch extends Model
{
    public $name, $kpp, $ogrn, $region_id;

    public function rules()
    {
        return [
            [['name','kpp', 'ogrn'], 'safe'],
            [['region_id'], 'integer'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = DictOrganizations::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['region_id' => $this->region_id]);

        $query
            ->andFilterWhere(['like', 'kpp', $this->kpp])
            ->andFilterWhere(['like', 'ogrn', $this->ogrn])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new DictOrganizations())->attributeLabels();
    }

}