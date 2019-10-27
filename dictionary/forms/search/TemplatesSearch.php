<?php


namespace dictionary\forms\search;


use dictionary\helpers\TemplatesHelper;
use dictionary\models\Templates;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TemplatesSearch extends Model
{
    public $name;
    public $type_id;

    public function rules(): array
    {
        return [
            [['type_id'], 'integer'],
            [['name',], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Templates::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'type_id' => $this->type_id
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function attributeLabels(): array
    {
        return Templates::labels();
    }

    public function typeTemplatesList(): array
    {
        return TemplatesHelper::typeTemplatesList();
    }

}