<?php
namespace backend\forms\dictionary;

use common\models\dictionary\Faculty;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class FacultySearch extends Model
{
    public $id;
    public $full_name;

    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['full_name',], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Faculty::find();

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
        ]);

        $query
            ->andFilterWhere(['like', 'full_name', $this->full_name]);

        return $dataProvider;
    }

    public function attributeLabels(): array
    {
        return  Faculty::labels();
    }

}