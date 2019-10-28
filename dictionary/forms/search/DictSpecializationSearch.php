<?php


namespace dictionary\forms\search;


use dictionary\helpers\DictSpecialityHelper;
use dictionary\models\DictSpecialization;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DictSpecializationSearch extends Model
{
    public $name, $speciality_id;

    public function rules(): array
    {
        return [
            [['speciality_id'], 'integer'],
            [['name','code'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = DictSpecialization::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'speciality_id' => $this->speciality_id,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function attributeLabels(): array
    {
        return DictSpecialization::labels();
    }

    public function specialityNameAndCodeList(): array
    {
        return DictSpecialityHelper::specialityNameAndCodeList();
    }

}