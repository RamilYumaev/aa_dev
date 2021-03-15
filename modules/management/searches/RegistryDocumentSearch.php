<?php

namespace modules\management\searches;


use modules\management\models\RegistryDocument;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class RegistryDocumentSearch extends Model
{
    public $name, $category_document_id;

    public function rules()
    {
        return [
            [['name'], 'safe'],
            [['category_document_id'], 'integer'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = RegistryDocument::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['category_document_id' => $this->category_document_id]);

        $query
            ->andFilterWhere(['like', 'name', $this->name]);


        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new RegistryDocument())->attributeLabels();
    }

}