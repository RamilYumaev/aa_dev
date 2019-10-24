<?php
namespace olympic\forms\dictionary\search;

use olympic\helpers\dictionary\CategoryDocHelper;
use olympic\models\dictionary\CategoryDoc;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CategoryDocSearch extends Model
{
    public $id;
    public $name;
    public $type_id;

    public function rules(): array
    {
        return [
            [['id', 'type_id'], 'integer'],
            [['name',], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = CategoryDoc::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type_id' => $this->type_id
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function attributeLabels(): array
    {
        return  CategoryDoc::labels();
    }

    public function categoryTypeList(): array
    {
        return CategoryDocHelper::categoryDocTypeList();
    }


}