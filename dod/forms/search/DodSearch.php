<?php
namespace dod\forms\search;

use dod\models\Dod;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DodSearch extends Model
{
    public $name;

    public function rules(): array
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
        $query = Dod::find();

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

    public function attributeLabels(): array
    {
        return Dod::labels();
    }

}