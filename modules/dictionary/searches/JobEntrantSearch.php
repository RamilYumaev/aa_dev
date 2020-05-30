<?php
namespace modules\dictionary\searches;

use modules\dictionary\models\JobEntrant;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class JobEntrantSearch extends  Model
{
    public  $faculty_id, $user_id, $category_id, $status;

    public function rules()
    {
        return [
            [['user_id', 'faculty_id', 'status', 'category_id'], 'integer'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = JobEntrant::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'category_id'=> $this->category_id,
            'status'=> $this->status,
            'faculty_id'=> $this->faculty_id,
        ]);

        return $dataProvider;
    }

}